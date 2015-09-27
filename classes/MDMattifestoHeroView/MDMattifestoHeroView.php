<?php

final class MDMattifestoHeroView {

    public static function renderModelAsHTML(stdclass $model) {
        CBHTMLOutput::addCSSURL('https://fonts.googleapis.com/css?family=Crimson+Text');

        ?>

        <style>

            .MDMattifestoHeroView {
                background-image: radial-gradient(circle closest-side, hsl(0, 100%, 40%), hsl(0, 100%, 30%));
                color: hsla(0, 100%, 100%, 0.5);
                display: flex;
                display: -webkit-flex;
                flex-direction: column;
                -webkit-flex-direction: column;
                font-size: 24px;
                height: 100vh;
                justify-content: space-around;
                -webkit-justify-content: space-around;
                min-height: 30vw;
                position: relative;
                text-align: center;
            }

            .MDMattifestoHeroView .arrow {
                bottom: 5px;
                color: hsla(0, 100%, 100%, 0.2);
                position: absolute;
                text-align: center;
                width: 100%;

            }

            .MDMattifestoHeroView .text {
                display: flex;
                display: -webkit-flex;
                flex-direction: column;
                -webkit-flex-direction: column;
                height: 5em;
                justify-content: center;
                -webkit-justify-content: center;
                padding: 0 20px;
            }

            @media all and (min-width: 1281px), all and (min-height: 801px) {
                .MDMattifestoHeroView {
                    font-size: 24px;
                }
            }

            @media all and (max-width: 640px), all and (max-height: 640px) {
                .MDMattifestoHeroView {
                    font-size: 18px;
                }
            }

            .MDMattifestoHeroView .mattifesto {
                color: white;
                font-family: "Crimson Text";
                font-size: 15vw;
                line-height: 1;
            }

        </style>
        <div class="MDMattifestoHeroView">
            <div class="CBSiteFontFamily text"><span>EST. 2008</span></div>
            <div class="mattifesto">Mattifesto</div>
            <div class="CBSiteFontFamily text"><span>Technology, Software Development, and Consulting for Websites</span></div>
            <div class="arrow">&#9660;</div>
        </div>

        <?php
    }
}
