const bs = new BottomSheet();
const bp = new BpClass();
let chart = null;
let installedAppsResolver = null;
const loaderSpinner = `<div class="flex items-center justify-center m-auto h-[calc(100vh-20rem)] w-full text-center">
    <img class="size-10" src="./assets/gif/loader.gif" />
</div>`;

if (typeof Android === 'undefined' && navigator.userAgent.includes("Windows")) {
	window.Android = {
		showToast: function(msg) {

		},
		
		pingAddress: function(ip) {
          return 100 || 200;
		},
 
		hasPermission: function() {
			return true;
		},

		openTab: function(tabName) {

		},

		userInfo: function(userInfo) {
			return 'behrouzpangul@gmail.com';
		},
 
		getLanguage: function() {
			return $(`html`).attr(`lang`);
		},

		getInstalledApps: function() {
			installedAppsResolver(`com.supercell.clashofclans,fi.twomenandadog.zombiecatchers`);
			installedAppsResolver = null;
		},
		setClipboard: function(setClipboard) {

		},

	};
}

 
 
	
if (typeof WebView === 'undefined') {
	window.WebView = {
		onPageFinished: function() {

		},

pingedAddress: function(ip, pinged) {
	let bgColor = `bg-green-500`;
	let textColor = `text-green-500`;
	let ping = pinged;

	if (pinged == -1 || pinged === "-1") {
		bgColor = `bg-red-500`;
		textColor = `text-red-500`;
		ping = `0`;
		$(`.watch-item[data-ip="${ip}"] .pinged-overlay`).fadeIn(300); 
	} else {
		ping = parseInt(pinged);

		if (ping <= 40) textColor = `text-green-500`;
		else if (ping <= 80) textColor = `text-yellow-500`;
		else if (ping <= 150) textColor = `text-orange-500`;
		else textColor = `text-red-500`;
 
		$(`.watch-item[data-ip="${ip}"]`).removeClass(`pointer-events-none`);
		$(`.watch-item[data-ip="${ip}"] .pinged-overlay`).fadeOut(300);
	}
 
	$(`.watch-item[data-ip="${ip}"] .pinged-status`)
		.removeClass(`bg-green-500 bg-yellow-500 bg-orange-500 bg-red-500`)
		.addClass(bgColor);
  
	$(`.watch-item[data-ip="${ip}"] .pinged`)
		.removeClass(`text-green-500 text-yellow-500 text-orange-500 text-red-500`)
		.addClass(textColor) 
		.fadeOut(300)
		.fadeIn()
		.html(ping);
},

 
  

		getInstalledApps: function(appsJson) {
			installedAppsResolver(appsJson);
			installedAppsResolver = null;
		},
 
		askPermission: function(permission, status) {
			updatePermissionUI();
		},

		googleAPI: function() {
			return $(`html`).data(`googleapi`);
		},

		onKeyDown: function(key) {
			$('[id^="bs-overlay-"]').last().click();
		},
		
		onResume: function() {
			refreshAppList();
		},

		handleSignInResult: function(data) {
			if (data === true) {

				$.ajax({
					url: "./includes/post.php",
					method: "POST",
					data: {
						key: "requestLoginViaGoogle",
						email: Android.userInfo(`email`),
						givenName: Android.userInfo(`name`),
						profileUrl: Android.userInfo(`photo`),
						deviceID: Android.deviceID(),
						lang: $(`html`).attr(`lang`),
					},
					success: function(response) {
						if (response.code === 200) {

							bs.close(`signIn`);

						} else {

							Android.rmData(`userInfo`);


							bs.make({
								id: 'requestLoginViaGoogle',
								size: `auto`,
								draggable: true,
								className: {
									body: 'bg-main-0'
								},
								title: {
									content: null,
									className: null
								},
								message: {
									content: response.message,
									className: `block p-3`
								},
								onOpen: () => {


								},
							});

						}
					},
					error: function(xhr, status, error) {

					},
					complete: function() {

					}
				});
			}


			if (data !== true) {


				const error = data.split(`:`);

				bs.make({
					id: 'handleSignInResult',
					size: `auto`,
					draggable: true,
					className: {
						body: 'bg-main-0'
					},
					title: {
						content: null,
						className: null
					},
					message: {
						content: error[1],
						className: `block p-3`
					},
					onOpen: () => {


					},
				});

			}


		},
	};
}




const lazyload = lozad('.lozad', {
	loaded: async (el) => {
		const imageUrl = el.dataset.backgroundImage;
		const exists = await checkImageExists(imageUrl);
		el.style.backgroundImage = `url('${exists ? imageUrl : './assets/png/logo.png'}')`;
	},
	error: (el) => {
		el.style.backgroundImage = `url('./assets/png/logo.png')`;
	}
});

function fetchInstalledApps() {
        return new Promise(resolve => {
            installedAppsResolver = resolve;
            Android.getInstalledApps();  
        });
}

function refreshAppList(){
    bp.removeHtmlCachedDataByKey(`pages/make/app.php?type=app`);
    bp.removeHtmlCachedDataByKey(`pages/make/app.php?type=game`);
    bp.removeHtmlCachedDataByKey(`pages/make/app.php?type=webview`);
}

function checkImageExists(url) {
	return new Promise((resolve) => {
		const img = new Image();
		if (url.startsWith('data:image/png;base64')) {
			img.onload = () => resolve(true);
			img.onerror = () => resolve(false);
			img.src = url;
		} else {
			img.onload = () => resolve(true);
			img.onerror = () => resolve(false);
			img.src = url;
		}
	});
}


function cloneMessage(email, target, imageUrl, messageText, timeText) {

	const $clone = $('.message-body').last().clone(true, true);

	// آپدیت ایمیل در onclick پروفایل
	$clone.find('[onclick^="viewPV"]').attr('onclick', `viewPV(\`${email}\`)`);
	$clone.find('[onclick^="viewPV"]').addClass('shimmer');

	// آپدیت متن و setClipboard
	$clone.find('[onclick^="setClipboard"]').attr('onclick', `setClipboard(\`${messageText}\`)`);
	$clone.find('[onclick^="setClipboard"]').addClass('shimmer');

	$clone.find('.text-white').text(messageText).addClass('shimmer');
	$clone.find('.text-gray-600').text(timeText).addClass('shimmer');

	// تغییر تصویر پروفایل (data-background-image و style.backgroundImage)
	const $avatar = $clone.find('[data-background-image]');
	if (imageUrl && $avatar.length) {
		$avatar.attr('data-background-image', imageUrl);
	}

	// خالی‌کردن main و قرار دادن کلون درونش
	$('#msg-list:last').append($clone);

	requestAnimationFrame(() => {
		$('.message-body').last()[0]?.scrollIntoView();
	});
}



function selectLanguage() {


	bs.make({
		id: 'selectLanguage',
		size: `auto`,
		draggable: true,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-selectLanguage`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/selectLanguage.php',
				data: {
					email: Android.userInfo('email'),
					lang: $(`html`).attr(`lang`),
				},
				ttl: 604800,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-selectLanguage`).html(response);
					}
					ajaxLoaded();
				}
			});

		},
	});



}

// نمایش صفحه PV در BottomSheet
function viewPV(target) {

	if (Android.userInfo(`email`) == target) {
		closePV();
		return;
	}


	bs.make({
		id: 'viewPV',
		size: 100,
		draggable: false,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-viewPV`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/make/direct.php',
				data: {
					target: target,
					email: Android.userInfo(`email`),
					lang: $(`html`).attr(`lang`),
				},
				ttl: 0,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-viewPV`).html(response);
					}
					ajaxLoaded();
				}
			});

		},
	});

}

function closePV() {
	bs.close('viewPV');
}



function about() {


	bs.make({
		id: 'about',
		size: `auto`,
		draggable: false,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-about`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/about.php',
				data: {
					email: Android.userInfo(`email`),
					lang: $(`html`).attr(`lang`),
				},
				ttl: 604800,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-about`).html(response);
					}
					ajaxLoaded();
				}
			});

		},
	});


}

function encryptData(text, key) {
	if (typeof text === 'object') {
		text = JSON.stringify(text);
	}

	// تبدیل به base64
	const base64 = btoa(text);

	// برعکس کردن رشته
	const reversed = base64.split('').reverse().join('');

	// رمزنگاری با XOR
	let encrypted = '';
	for (let i = 0; i < reversed.length; i++) {
		encrypted += String.fromCharCode(
			reversed.charCodeAt(i) ^ key.charCodeAt(i % key.length)
		);
	}

	// تبدیل خروجی نهایی به base64 برای اینکه قابل انتقال باشه
	return btoa(encrypted);
}

function decryptData(encodedText, key) {
	// decode base64
	const encrypted = atob(encodedText);

	// رمزگشایی با XOR
	let reversed = '';
	for (let i = 0; i < encrypted.length; i++) {
		reversed += String.fromCharCode(
			encrypted.charCodeAt(i) ^ key.charCodeAt(i % key.length)
		);
	}

	// برگردوندن رشته به حالت اول
	const base64 = reversed.split('').reverse().join('');

	// نهایی: decode base64 اصلی برای به‌دست آوردن متن
	const decoded = atob(base64);

	// اگر JSON باشه، سعی می‌کنیم parse کنیم
	try {
		return JSON.parse(decoded);
	} catch (e) {
		return decoded;
	}
}

function signIn() {

	if (Android.userInfo(`email`).includes(`@`)) {
		return;
	}

	bs.make({
		id: 'signIn',
		size: `auto`,
		draggable: true,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-signIn`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/signIn.php',
				data: {
					email: Android.userInfo(`email`),
					lang: $(`html`).attr(`lang`),
				},
				ttl: 604800,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-signIn`).html(response);
					}
					ajaxLoaded();
				}
			});

		},
		onClose: () => {
			signIn();
		}
	});

}



$(document).on('click', '[onclick]', function(e) {
	const $el = $(this);

	if (!$el.hasClass('pointer-events-none')) {
		$el.addClass('pointer-events-none');

		setTimeout(function() {
			$el.removeClass('pointer-events-none');
		}, 300);

	}
});

function sendMessage() {
	const $textarea = $("textarea:last");
	const message = $textarea.val().trim();
	const sender = $textarea.data("sender");
	const receiver = $textarea.data("receiver");

	if (!message) return;

	const type = $("#bs-viewPV").length ? receiver : "group";
	const $sendButton = $("#send-btn");

	$textarea.addClass("pointer-events-none opacity-50");
	$sendButton.addClass("pointer-events-none opacity-50");
 
	const sendAjaxRequest = (url, data, successCallback) => {
		$.ajax({
			url: url,
			method: "POST",
			data: data,
			success: successCallback,
			error: function(xhr, status, error) {

			},
			complete: function() {
				$textarea.removeClass("pointer-events-none opacity-50");
				$sendButton.removeClass("pointer-events-none opacity-50");
				ajaxLoaded();
			}
		});
	};

	if ($('.message-body').last().length === 0 && type !== "group") {
		$(`#msg-list`).addClass(`shimmer`);
		sendAjaxRequest("./includes/post.php", {
			key: "sendMessage",
			sender: sender,
			receiver: type,
			message: message,
			lang: $(`html`).attr(`lang`),
		}, function(response) {
			$(`#msg-list`).removeClass(`shimmer`);
			if (response.code === 200) {
				sendAjaxRequest("./pages/make/direct.php", {
					email: Android.userInfo('email'),
					target: type,
					lang: $(`html`).attr(`lang`),
				}, function(response) {
					let $html = $(response);
					let msgListContent = $html.find('#msg-list').html();
					$('#msg-list:last').html(msgListContent);
				});
			}
		});
	} else {
		cloneMessage(
			Android.userInfo('email'),
			receiver,
			Android.userInfo('photo'),
			message,
			language['hnjzbq'][$(`html`).attr(`lang`)]
		);

		sendAjaxRequest("./includes/post.php", {
			key: "sendMessage",
			sender: sender,
			receiver: type,
			message: message,
			lang: $(`html`).attr(`lang`),
		}, function(response) {
			if (response.code === 200) {
				$textarea.val("");
				$('.message-body, .message-body *').removeClass('shimmer');
			}
		});
	}
}

function privacy() {

	bs.make({
		id: 'privacy',
		size: `auto`,
		draggable: false,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-privacy`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/privacy.php',
				data: {
					email: Android.userInfo(`email`),
					lang: $(`html`).attr(`lang`),
				},
				ttl: 604800,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-privacy`).html(response);
					}
					ajaxLoaded();
				}
			});

		},
	});


}

function edit() {


	bs.make({
		id: 'edit',
		size: `auto`,
		draggable: true,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-edit`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/edit.php',
				data: {
					email: Android.userInfo(`email`),
					lang: $(`html`).attr(`lang`),
				},
				ttl: 604800,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-edit`).html(response);
					}
					ajaxLoaded();
				}
			});

		},
	});



}

function buy() {

	bs.make({
		id: 'buy',
		size: `auto`,
		draggable: true,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-buy`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/buy.php',
				data: {
					email: Android.userInfo(`email`),
					lang: $(`html`).attr(`lang`),
				},
				ttl: 0,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-buy`).html(response);
					}
					ajaxLoaded();
				}
			});

		},
	});



}

function changeLanguage(lang) {
	Android.setData("lang", lang, -1);
	bp.removeHtmlCachedData();
	setTimeout(function() {
	   Android.restart();
	}, 300);
}

function bottomBar() {
	const $bottomBarElement = $('#bottom-bar');

	// اگر قبلاً این بخش مقداردهی شده، دیگه کاری نکن
	if ($bottomBarElement.data('initialized')) return;

	const $navigationItems = $bottomBarElement.find('.nb-item');
	const contentContainer = $('#contents');

	$navigationItems.on('click', function() {
		const $navigationItem = $(this);
		const targetUrl = $navigationItem.data('url');

		if (!targetUrl) return;

		$navigationItems.removeClass('active');
		$navigationItem.addClass('active');

		bp.makeRequest({
			url: targetUrl,
			data: {
				email: Android.userInfo('email'),
				lang: $(`html`).attr(`lang`),
			},
			ttl: 604800,
			callback: (status, response) => {
				if (status === 'success') {
					contentContainer.html(response);
				}
				ajaxLoaded();
			},
		});
	});


	$bottomBarElement.data('initialized', true);

	$bottomBarElement.find('.nb-item.active').trigger('click');
}


function tabBar() {
    $('[data-tab-container]').each(function() {
        const $container = $(this);
        if ($container.data('initialized')) return;

        const $wrap = $container.closest('div[id^="tabs-"]');
        const $tabs = $container.find('[data-tab]');
        const $indicator = $wrap.find('[data-indicator]');
        const $contentArea = $wrap.find('[data-content]');

        $tabs.on('click', async function() {
            const $tab = $(this);
            if ($tab.hasClass('text-white') && $tab.hasClass('font-bold')) return;

            $tabs.removeClass('text-white font-bold');
            $tab.addClass('text-white font-bold');

            if ($indicator.length) {
                const left = $tab.position().left;
                const width = $tab.outerWidth();
                $indicator.css({ left, width });
            }

            const url = $tab.data('url');
            if (!url) return;

            const dynamicTTLUrls = ['group', 'direct', 'private', 'profile', 'server'];
            const isProfileTTL = new RegExp(dynamicTTLUrls.join('|'), 'i').test(url);
            const includeIDs = url.includes('app.php');

            // build base requestData
            const requestData = {
                email: Android.userInfo('email'),
                lang: $('html').attr('lang'),
            };

            if (includeIDs) {
                const ids = await fetchInstalledApps();
                requestData.ids = ids;
            }

            $contentArea.html(loaderSpinner);
            bp.makeRequest({
                url,
                data: requestData,
                ttl: isProfileTTL ? 0 : 604800,
                callback: (status, response) => {
                    if (status === 'success') {
                        $contentArea.html(response);
                        ajaxLoaded();
                    }
                },
            });
        });

        // trigger the active tab on init...
        const $activeTab = $tabs.filter('.active');
        if ($activeTab.length && $indicator.length) {
            $indicator.css({
                left: $activeTab.position().left,
                width: $activeTab.outerWidth(),
            });
        }
        if ($activeTab.length) {
            $activeTab.trigger('click');
        }

        $container.data('initialized', true);
    });
}




function setClipboard(str) {
	Android.setClipboard(str);


	bs.make({
		id: 'setClipboard',
		size: `auto`,
		draggable: true,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: language[`jhjuha`][$(`html`).attr(`lang`)],
			className: `block p-3`
		},
		onOpen: () => {},
	});

}

function updatePermissionUI() {

	if (Android.hasPermission(`POST_NOTIFICATIONS`) && Android.hasPermission(`BIND_VPN_SERVICE`)) {
		bs.close('askPermission');
		return;
	}

	if (Android.hasPermission(`POST_NOTIFICATIONS`)) {
		$(`.post-notify`).addClass(`bg-green-500 pointer-events-none`);
	}

	if (Android.hasPermission(`BIND_VPN_SERVICE`)) {
		$(`.vpn-service`).addClass(`bg-green-500 pointer-events-none`);
	}



}

function connectTo(attr) {
	askPermission();


}

function askPermission() {

	if (Android.hasPermission(`POST_NOTIFICATIONS`) && Android.hasPermission(`BIND_VPN_SERVICE`)) {
		bs.close('askPermission');
		return;
	}


	bs.make({
		id: 'askPermission',
		size: `auto`,
		draggable: true,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-askPermission`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/askPermission.php',
				data: {
					email: Android.userInfo(`email`),
					lang: $(`html`).attr(`lang`),
				},
				ttl: 604800,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-askPermission`).html(response);
						updatePermissionUI();
					}
					ajaxLoaded();
				}
			});

		},
	});



}

 


function scrollChecker() {
    const $scrollContainer = $('.overflow-auto');
    const $refreshContainer = $('.refresh');
	
    // اگه container وجود نداشت، از اسکرول جدا شو و برگرد
    if ($scrollContainer.length === 0) {
        $scrollContainer.off('scroll');
		$refreshContainer.off('click');
        return;
    }

    if ($scrollContainer.data('scrollListenerAdded')) return;

    // حذف handler قبلی (با namespace برای امنیت بیشتر)
    $scrollContainer.off('scroll');

    $scrollContainer.data('scrollListenerAdded', true);

    const watcher = function(){
        const now = Date.now();
        
        $('.watch-item').each(function () {
            const $item = $(this);
            const lastSeen = $item.data('seenTime') || 0;
            if (now - lastSeen >= 7000 && bp.isInViewport($item, $scrollContainer)) {
                $item.data('seenTime', now);
                const ip = $item.data(`ip`);
                if (ip.length){
                  Android.pingAddress(ip);
				}
            }
        });
    }

    // اضافه‌کردن scroll listener
    $scrollContainer.on('scroll', function () {
        watcher()
    });

    watcher();
    
	setTimeout(function() {
        watcher();
    }, 3000);


 
$refreshContainer.on('click', function () {
    const $btn = $(this);
    const $watchItem = $btn.closest('.watch-item');

    // گرفتن مقادیر
    const [currentIP, ipv4, ipv6, doh] = [
        $watchItem.attr("data-ip"),
        $watchItem.attr("data-ipv4"),
        $watchItem.attr("data-ipv6"),
        $watchItem.attr("data-doh")
    ];

    let nextIP = currentIP;
    let borderColor = 'border-gray-950';
    let badage = 'ipV4';
	
    if (currentIP === ipv4 && ipv6) {
        nextIP = ipv6;
        borderColor = 'border-yellow-500';
		badage = 'ipV6';
    } else if (currentIP === ipv6 && doh) {
        nextIP = doh;
        borderColor = 'border-green-500';
		badage = 'DoH';
    } else if ((currentIP === doh || currentIP !== ipv4) && ipv4) {
        nextIP = ipv4;
        borderColor = 'border-gray-950';
		badage = 'ipV4';
    }
 
    $btn.removeClass('border-green-500 border-yellow-500 border-gray-950')
    .addClass(`pointer-events-none ${borderColor}`).fadeOut(300).fadeIn().html(badage);
    
	 
	
    const $ipDisplay = $watchItem.find(".current-ip");
    $watchItem.attr("data-ip", nextIP);
    $ipDisplay.fadeOut(300, function () {
            $(this).html(nextIP).fadeIn();
            $(this).removeClass('text-green-500 text-yellow-500')
            if (borderColor !== 'border-gray-950') {
                $(this).addClass(borderColor.replace('border', 'text'));
            }
        });
    
	Android.pingAddress(nextIP);
	
    setTimeout(() => {
        $btn.removeClass("pointer-events-none");
    }, 500);
});


}



function showServers(attr) {

	if (!Android.hasPermission(`POST_NOTIFICATIONS`)) {
		askPermission();
		return;
	}

	if (!Android.hasPermission(`BIND_VPN_SERVICE`)) {
		askPermission();
		return;
	}


	bs.make({
		id: 'server',
		size: 90,
		draggable: false,
		className: {
			body: 'bg-main-0'
		},
		title: {
			content: null,
			className: null
		},
		message: {
			content: null,
			className: null
		},
		onOpen: () => {

			$(`#bs-server`).html(loaderSpinner);

			bp.makeRequest({
				url: './pages/server.php',
				data: {
					email: Android.userInfo(`email`),
					lang: $(`html`).attr(`lang`),
					appID: attr.appID
				},
				ttl: 604800,
				callback: (status, response) => {
					if (status === 'success') {
						$(`#bs-server`).html(response);
						updatePermissionUI();
					}
					ajaxLoaded();
				}
			});

		},
	});


}



$(document).ready(function() {
	refreshAppList(); //first
	ajaxLoaded();
});

// پس از بارگذاری AJAX
function ajaxLoaded() {
	if (typeof lazyload !== 'undefined') {
		lazyload.observe();
	}
	scrollChecker();
	bottomBar();
	tabBar();
	signIn();
	fixKeyboard();
}

function fixKeyboard(){

    const $container = $("textarea:last");

    if ($container.length === 0) {
        $container.off('blur');
        return;
    }
 
    if ($container.data('listenerAdded')) return;
 
    $container.off('blur');

    $container.data('listenerAdded', true);
	
	$container.on('blur', function() {
		if (document.activeElement !== this) {
		   this.focus();
		}
	});
}

 


 