OO.plugin("DiscoveryApi",function(e,i,t){var s=20;e.EVENTS.DISCOVERY_API={RELATED_VIDEOS_FETCHED:"relatedVideosFetched",SEND_DISPLAY_EVENT:"sendDisplayEvent",DISPLAY_EVENT_SUCCESS:"displayEventSuccess",SEND_CLICK_EVENT:"sendClickEvent",CLICK_EVENT_SUCCESS:"clickEventSuccess",DISPLAY_EVENT_ERROR:"displayEventError",CLICK_EVENT_ERROR:"clickEventError"};var r=[];e.exposeStaticApi("EVENTS",e.EVENTS);var a=function(i,t){e.requiredInEnvironment("html5-playback")&&(this.id=t,this.mb=i,this.error=!1,this.relatedVideos=[],this.guid="",this.apiHost=e.playerParams.backlot_api_write_server||"api.ooyala.com",this.playerParams={},e.StateMachine.create({initial:"Init",messageBus:this.mb,moduleName:"DiscoveryApi",target:this,events:[{name:e.EVENTS.PLAYER_CREATED,from:"*"},{name:e.EVENTS.EMBED_CODE_CHANGED,from:"*"},{name:e.EVENTS.ASSET_CHANGED,from:"*"},{name:e.EVENTS.ASSET_UPDATED,from:"*"},{name:e.EVENTS.DISCOVERY_API.SEND_DISPLAY_EVENT,from:"*"},{name:e.EVENTS.DISCOVERY_API.SEND_CLICK_EVENT,from:"*"},{name:e.EVENTS.GUID_SET,from:"*"}]}))};return i.extend(a.prototype,{onPlayerCreated:function(e,i,t){this.playerParams=t},onEmbedCodeChanged:function(e,t){if(r=i.filter(r,function(e){return e!=t}),r.push(t),r.length>=s&&r.shift(),""===this.guid){var a=i.bind(function(){this._fetchRelatedVideos(t)},this);setTimeout(a,500)}else this._fetchRelatedVideos(t)},onAssetUpdated:function(e,i){this._setRelatedMedia(i)},onAssetChanged:function(e,i){this._setRelatedMedia(i)},_setRelatedMedia:function(i){i.relatedVideos&&(this.relatedVideos=i.relatedVideos,this.mb.publish(e.EVENTS.DISCOVERY_API.RELATED_VIDEOS_FETCHED,{videos:this.relatedVideos}))},onGuidSet:function(e,i){this.guid=i},onSendDisplayEvent:function(s,r){if(r){var a=r.relatedVideos;if(a&&i.isArray(a)&&!(i.size(a)<1)){var n=a[0].bucket_info;if(n){if("2"==n.charAt(0))return void this.mb.publish(e.EVENTS.REPORT_DISCOVERY_IMPRESSION,r);r={bucket_info:n,custom:r.custom};var o="http://"+this.apiHost+"/v2/discover/feedback/impression";r.device_id=this.guid,r.discovery_profile_id=e.playerParams.playerBrandingId,r.system="OOYALA",t.ajax({url:o,data:JSON.stringify(r),type:"POST",dataType:"json",crossDomain:!0,cache:!0,success:i.bind(this._displayEventSuccess,this),error:i.bind(this._displayEventError,this)})}}}},_displayEventSuccess:function(){this.mb.publish(e.EVENTS.DISCOVERY_API.DISPLAY_EVENT_SUCCESS)},_displayEventError:function(i,t,s){this.mb.publish(e.EVENTS.DISCOVERY_API.DISPLAY_EVENT_ERROR,{xhr:i,status:t,error:s})},onSendClickEvent:function(s,r){if(r){var a=r.clickedVideo;if(a){var n=a.bucket_info;if(n){if("2"==n.charAt(0))return void this.mb.publish(e.EVENTS.REPORT_DISCOVERY_CLICK,r);r={bucket_info:n,custom:r.custom};var o="http://"+this.apiHost+"/v2/discover/feedback/play";r.device_id=this.guid,r.discovery_profile_id=e.playerParams.playerBrandingId,r.system="OOYALA",t.ajax({url:o,data:JSON.stringify(r),type:"POST",dataType:"json",crossDomain:!0,cache:!0,success:i.bind(this._clickEventSuccess,this),error:i.bind(this._clickEventError,this)})}}}},_clickEventSuccess:function(){this.mb.publish(e.EVENTS.DISCOVERY_API.CLICK_EVENT_SUCCESS)},_clickEventError:function(i,t,s){this.mb.publish(e.EVENTS.DISCOVERY_API.CLICK_EVENT_ERROR,{xhr:i,status:t,error:s})},_fetchRelatedVideos:function(r){this.error=!1,this.relatedVideos=[];var a={sign_version:"player",pcode:e.playerParams.pcode,discovery_profile_id:e.playerParams.playerBrandingId,video_pcode:e.playerParams.pcode,limit:s,device_id:this.guid,expected_bucket_info_version:2,expires:Math.floor((new Date).getTime()/1e3+3600)};this.playerParams.discoveryApiAdditionalParams&&i.extend(a,this.playerParams.discoveryApiAdditionalParams);var n=encodeURIComponent(this._generateSignature(a));a.device_id=encodeURIComponent(a.device_id),a.where&&(a.where=encodeURIComponent(a.where));var o="//"+this.apiHost+"/v2/discover/similar/assets/"+r+"?"+this._generateParamString(a,n);t.ajax({url:o,type:"GET",dataType:"json",crossDomain:!0,cache:!0,success:i.bind(this._onRelatedVideosFetched,this),error:i.bind(this._onApiError,this)})},_onRelatedVideosFetched:function(i){var t=e.HM.safeObject("discovery.relatedVideos",i,{});void 0===t.errors||t.errors&&0===t.errors.code?(this.relatedVideos=t.results||[],this.variationIds=t.variation_ids):(this.relatedVideos=[],this.variationIds=[]),this._reorderRelatedVideos(),this.mb.publish(e.EVENTS.REPORT_EXPERIMENT_VARIATIONS,{variationIds:this.variationIds}),this.mb.publish(e.EVENTS.DISCOVERY_API.RELATED_VIDEOS_FETCHED,{videos:this.relatedVideos})},_onApiError:function(){this.error=!0,this.mb.publish(e.EVENTS.DISCOVERY_API.RELATED_VIDEOS_FETCHED,{error:!0})},_generateSignature:function(e){var t=e.pcode,s=i.reject(i.keys(e),function(e){return"pcode"===e}),r=new jsSHA(t+this._hashToString(e,"",s),"ASCII");return r.getHash("SHA-256","B64").substring(0,43)},_hashToString:function(e,t,s){var r="",a=s||i.keys(e);return i.each(i.sortBy(a,function(e){return e}),function(i){r+=t+i+"="+e[i]}),r},_generateParamString:function(e,i){var t="signature="+i+this._hashToString(e,"&");return t},_reorderRelatedVideos:function(){for(var e=0;e<r.length;e++){var t=i.find(this.relatedVideos,function(i){return i.embed_code==r[e]});t&&(this.relatedVideos=i.filter(this.relatedVideos,function(i){return i.embed_code!=r[e]}),this.relatedVideos.push(t))}}}),a});