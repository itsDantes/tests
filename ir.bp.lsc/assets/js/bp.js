class BpClass {
    #activeRequests = new Map();

    constructor() {}

    getUrlParams(url) {
        const params = {};
        const queryString = $('<a>').prop('href', url)[0].search.substring(1);
        const urlParams = new URLSearchParams(queryString);
        for (const [key, value] of urlParams.entries()) {
            params[key] = value;
        }
        return params;
    }
 
    removeHtmlCachedData() {
		localStorage.removeItem(`htmlCachedData`);
	}
	removeHtmlCachedDataByKey(key) {
    try {
        let rawData = localStorage.getItem('htmlCachedData');
        let data = rawData ? JSON.parse(rawData) : {};

        delete data[key];
        localStorage.setItem('htmlCachedData', JSON.stringify(data));
    } catch (e) {}
	}

 

    makeRequest({ url, data = {}, ttl = 0, callback }) {
        const expirationTime = ttl * 1000;
        const urlParams = this.getUrlParams(url);
        const mergedData = $.extend({}, urlParams, data);
        const cacheManager = (function () {
            const key = "htmlCachedData";
            const maxSize = 2 * 1024 * 1024;

            function read() {
                try {
                    return JSON.parse(localStorage.getItem(key)) || {};
                } catch (e) {
                    return {};
                }
            }

            function write(pageName, html) {
                const allCache = read();
                allCache[pageName] = {
                    created: Date.now(),
                    html: html
                };

                let serialized = JSON.stringify(allCache);
                while (serialized.length > maxSize) {
                    const oldestKey = Object.keys(allCache).reduce((oldest, key) => {
                        return !oldest || allCache[key].created < allCache[oldest].created ? key : oldest;
                    }, null);
                    if (!oldestKey) break;
                    delete allCache[oldestKey];
                    serialized = JSON.stringify(allCache);
                }

                try {
                    localStorage.setItem(key, serialized);
                } catch (e) {
                    if (e.name === 'QuotaExceededError') {
                        console.warn("localStorage is full. Cache write skipped.");
                    }
                }
            }

            return { read, write };
        })();
		
const showError = (show) => {
  const wrapperId = 'reconnectWrapper';
  const $wrapper = $(`#${wrapperId}`);
  const isRTL = $('html').attr('dir') === 'rtl'; // بررسی جهت صفحه

  if (show) {
    if (!$wrapper.length) {
      const html = `
        <div id="${wrapperId}" class="fixed bottom-20 ${isRTL ? 'right-4' : 'left-4'} z-50 slide-in">
          <div class="relative flex items-center"> 
            <div id="loaderBox" class="relative z-2 w-14 h-14 rounded-full @border-2 bg-main-2 border-green-400 shadow-lg flex items-center justify-center">
              <img class="size-10" src="./assets/gif/loader.gif" />
            </div>
            <div id="reconnectMessage"
                 class="${isRTL ? '-mr-3' : '-ml-3'} relative z-1 @border-2 bg-main-2 border-green-400 text-gray-50 text-sm px-4 py-2 rounded-lg shadow-lg hidden">
              ${language[`juiopc`][$('html').attr('lang')]}
            </div>
          </div> 
        </div>
      `;
      $('body').append(html);

      setTimeout(() => {
        $('#reconnectMessage').removeClass('hidden').addClass('spring-in');
      }, 2000);
    }
  } else {
    if ($wrapper.length) {
      $('#reconnectMessage').removeClass('spring-in').addClass('spring-out');
      setTimeout(() => {
        $wrapper.removeClass('slide-in').addClass('slide-out');
        setTimeout(() => $wrapper.remove(), 300);
      }, 300);
    }
  }  
}



        const pageName = url;
        const cachedData = cacheManager.read();

        if (cachedData[pageName] && (Date.now() - cachedData[pageName].created < expirationTime)) {
            callback('success', cachedData[pageName].html);
            return;
        }

        if (this.#activeRequests.has(url)) {
            this.#activeRequests.get(url).abort();
        }

        let shouldRetry = true;

        const tryRequest = () => {
            const ajaxRequest = $.ajax({
                url: url,
                method: 'POST',
                data: mergedData,
				timeout: 5000, 
                success: (response) => {
                    shouldRetry = false; 
					showError(shouldRetry);
                    if (expirationTime > 0) {
                        cacheManager.write(pageName, response);
                    }
                    callback('success', response);
                },
                error: (xhr, status, error) => {
                    if (shouldRetry) { 
                        setTimeout(() => {
                            if (shouldRetry) tryRequest();
                        }, 3000);
						showError(shouldRetry);
                    }
                    callback('error', error);
                },
                complete: () => {
                    this.#activeRequests.delete(url);
					shouldRetry = true;
                } 
            });

            this.#activeRequests.set(url, ajaxRequest);
        };

        tryRequest();
    }
	
	
 
  isInViewport(element, container) {
    const $el = $(element);
    const $container = $(container);

    if ($el.length === 0 || $container.length === 0) {
        return false;
    }

    const elTop = $el.offset().top;
    const elBottom = elTop + $el.outerHeight();

    const containerTop = $container.offset().top;
    const containerBottom = containerTop + $container.innerHeight();

    return elBottom > containerTop && elTop < containerBottom;
}



}
