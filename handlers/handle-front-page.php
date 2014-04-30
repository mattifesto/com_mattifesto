<?php

include_once CBSystemDirectory . '/classes/CBHTMLOutput.php';


CBHTMLOutput::setTitleHTML(CBSiteNameHTML);
CBHTMLOutput::setDescriptionHTML('Mattifesto Design sells web design for Seattle, Bellevue, Kirkland, Redmond, and Western Washington');
CBHTMLOutput::begin();

CBHTMLOutput::addCSSURL(CBSiteURL . '/handlers/handle-front-page.css');

?>

<div id="main">
    <img id="mattifesto" src="images/mattifesto.png" alt="Mattifesto" />
    <img id="design" src="images/design.png" alt="Design" />
    <a id="email" href="mailto:matt@mattifesto.com">
        <span>matt@mattifesto.com</span>
    </a>
</div>

<?php

CBHTMLOutput::render();
