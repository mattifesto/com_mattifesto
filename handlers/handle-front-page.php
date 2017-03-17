<?php

CBHTMLOutput::setTitleHTML(cbhtml(CBSitePreferences::siteName()));
CBHTMLOutput::setDescriptionHTML('Mattifesto Design web design and development services for Seattle, Bellevue, Kirkland, Redmond, and Western Washington');
CBHTMLOutput::begin();
CBHTMLOutput::addCSSURL(CBSiteURL . '/handlers/handle-front-page.css');

?>

<div id="main">
    <img id="mattifesto" src="images/mattifesto.png" alt="Mattifesto" />
    <img id="design" src="images/design.png" alt="Design" />
    <a id="email" href="mailto:matt@mattifesto.com">
        <span>matt@mattifesto.com</span>
    </a>
    <footer>
        <a href="http://dreamhost.com/redir.cgi?target=signup&type=shared&promo=mattifesto">Dreamhost web hosting coupon</a>
    </footer>
</div>

<?php

CBHTMLOutput::render();
