// Contract with snippets/banner.php and snippets/settings.php:
// - [data-consent]: the banner, rendered `hidden`; [data-consent-id] holds the GA id.
// - [data-consent-choice="granted|denied"]: the buttons that record a choice.
// - [data-consent-open]: the footer button that reopens the banner, rendered `hidden`.
// - localStorage `consent`: "granted", "denied" or missing (banner shown).
// Both elements stay hidden without JS, so nothing is offered that can't work.
// Other tracking scripts load next to loadAnalytics() and get their cookies
// added to clearAnalyticsCookies().
(() => {
	const banner = document.querySelector("[data-consent]");

	if (!banner) {
		return;
	}

	const key = "consent";
	const id = banner.dataset.consentId;
	const opener = document.querySelector("[data-consent-open]");

	const read = () => {
		try {
			return localStorage.getItem(key);
		} catch {
			return null;
		}
	};

	const write = (value) => {
		try {
			localStorage.setItem(key, value);
		} catch {}
	};

	const loadAnalytics = () => {
		window.dataLayer = window.dataLayer || [];
		window.gtag = function () {
			dataLayer.push(arguments);
		};
		gtag("js", new Date());
		gtag("config", id);

		const script = document.createElement("script");
		script.async = true;
		script.src = "https://www.googletagmanager.com/gtag/js?id=" + encodeURIComponent(id);
		document.head.append(script);
	};

	// GA sets its cookies on the widest domain it can, so try every level.
	const clearAnalyticsCookies = () => {
		const parts = location.hostname.split(".");
		const domains = parts.map((_, i) => parts.slice(i).join("."));

		document.cookie.split(";").forEach((cookie) => {
			const name = cookie.split("=")[0].trim();

			if (!name.startsWith("_ga")) {
				return;
			}

			domains.forEach((domain) => {
				document.cookie = `${name}=; Max-Age=0; path=/; domain=${domain}`;
			});
			document.cookie = `${name}=; Max-Age=0; path=/`;
		});
	};

	let reopened = false;

	const open = () => {
		reopened = true;
		banner.hidden = false;
		banner.querySelector("button").focus();
	};

	// Only hand focus back when the visitor came from the settings button.
	const close = () => {
		banner.hidden = true;

		if (reopened) {
			reopened = false;
			opener.focus();
		}
	};

	banner.addEventListener("click", (event) => {
		const value = event.target.closest("[data-consent-choice]")?.dataset.consentChoice;

		if (!value) {
			return;
		}

		const previous = read();
		write(value);

		if (value === "granted" && previous !== "granted") {
			loadAnalytics();
		}

		// A loaded gtag can't be unloaded: clear its cookies and start clean.
		if (value === "denied" && previous === "granted") {
			clearAnalyticsCookies();
			location.reload();
			return;
		}

		close();
	});

	banner.addEventListener("keydown", (event) => {
		if (event.key === "Escape" && read()) {
			close();
		}
	});

	if (opener) {
		opener.hidden = false;
		opener.addEventListener("click", open);
	}

	const stored = read();

	if (stored === "granted") {
		loadAnalytics();
	} else if (!stored) {
		banner.hidden = false;
	}
})();
