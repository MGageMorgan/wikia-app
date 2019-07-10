<?php

namespace Wikia\Service\Swagger;

use Swagger\Client\Configuration;
use Wikia\CircuitBreaker\CircuitBreaker;
use Wikia\Service\Gateway\UrlProvider;
use Wikia\Service\Constants;
use Wikia\Util\Statistics\BernoulliTrial;

class ApiProvider {

	/** @var UrlProvider */
	private $urlProvider;

	/** @var BernoulliTrial */
	private $clientLogSampler;

	/** @var CircuitBreaker */
	private $circuitBreaker;

	/**
	 * @Inject({
	 *   Wikia\Service\Gateway\UrlProvider::class,
	 *   Wikia\Service\Swagger\ApiProviderModule::API_CLIENT_LOG_SAMPLER})
	 * ApiProvider constructor.
	 * @param UrlProvider $urlProvider
	 * @param BernoulliTrial $clientLogSampler
	 */
	public function __construct(UrlProvider $urlProvider, BernoulliTrial $clientLogSampler, CircuitBreaker $circuitBreaker) {
		$this->urlProvider = $urlProvider;
		$this->clientLogSampler = $clientLogSampler;
		$this->circuitBreaker = $circuitBreaker;
	}

	public function getApi($serviceName, $apiClass) {
		$apiClient = $this->getApiClient($serviceName);
		return new $apiClass($apiClient);
	}

	public function getAuthenticatedApi($serviceName, $userId, $apiClass) {
		if ( $userId === 0 ) {
			return $this->getApi( $serviceName, $apiClass );
		}

		$apiClient = $this->getApiClient($serviceName);
		$apiClient->getConfig()->setApiKey(Constants::HELIOS_AUTH_HEADER, $userId);

		return new $apiClass($apiClient);
	}

	private function getApiClient($serviceName) {
		$config = (new Configuration())
			->setHost($this->urlProvider->getUrl($serviceName));

		return new ApiClient($config, $this->clientLogSampler, $this->circuitBreaker, $serviceName);
	}
}
