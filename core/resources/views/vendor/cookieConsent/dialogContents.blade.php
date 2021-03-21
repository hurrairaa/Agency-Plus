<div class="js-cookie-consent cookie-consent">

    <div class="container">
      <div class="cookie-container">
        <span class="cookie-consent__message">
          {!! replaceBaseUrl($be->cookie_alert_text) !!}
        </span>

        <button class="js-cookie-consent-agree cookie-consent__agree">
            {!! $be->cookie_alert_button_text !!}
        </button>
      </div>
    </div>

</div>
