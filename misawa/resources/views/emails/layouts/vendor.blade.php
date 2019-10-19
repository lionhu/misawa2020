<!DOCTYPE html>
<html lang="it">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>CANVAS</title><!--


COLORE INTENSE  #9C010F
COLORE LIGHT #EDE8DA

TESTO LIGHT #3F3D33
TESTO INTENSE #ffffff


 -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <style type="text/css">#ko_onecolumnBlock_9 .textintenseStyle a:visited, #ko_onecolumnBlock_9 .textintenseStyle a:hover {
            color: #fff;
            color:;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_onecolumnBlock_9 .textlightStyle a, #ko_onecolumnBlock_9 .textlightStyle a:link, #ko_onecolumnBlock_9 .textlightStyle a:visited, #ko_onecolumnBlock_9 .textlightStyle a:hover {
            color: #3f3d33;
            color:;
            text-decoration: none;
            text-decoration:;
            font-weight: bold;
        }

        #ko_twocolumnBlock_7 .textsmallintenseStyle a, #ko_twocolumnBlock_7 .textsmallintenseStyle a:link, #ko_twocolumnBlock_7 .textsmallintenseStyle a:visited, #ko_twocolumnBlock_7 .textsmallintenseStyle a:hover {
            color: #fff;
            color:;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_twocolumnBlock_7 .textsmalllightStyle a:visited, #ko_twocolumnBlock_7 .textsmalllightStyle a:hover {
            color: #3f3d33;
            color:;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_compactarticlerightBlock_6 .articletextintenseStyle a, #ko_compactarticlerightBlock_6 .articletextintenseStyle a:link, #ko_compactarticlerightBlock_6 .articletextintenseStyle a:visited, #ko_compactarticlerightBlock_6 .articletextintenseStyle a:hover {
            color: #fff;
            color:;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }

        #ko_compactarticlerightBlock_6 .articletextlightStyle a:visited, #ko_compactarticlerightBlock_6 .articletextlightStyle a:hover {
            color: #3f3d33;
            color:;
            text-decoration: none;
            text-decoration: none;
            font-weight: bold;
        }
        .customer_title{
            width: 80px;
        }
    </style>
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        #outlook a {
            padding: 0;
        }

        /* Force Outlook to provide a "view in browser" message */
        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
            line-height: 100%;
        }

        /* Force Hotmail to display normal line spacing */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        /* Prevent WebKit and Windows mobile changing default text sizes */
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        /* Remove spacing between tables in Outlook 2007 and up */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* Allow smoother rendering of resized image in Internet Explorer */

        /* RESET STYLES */
        body {
            margin: 0;
            padding: 0;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        .appleBody a {
            color: #68440a;
            text-decoration: none;
        }

        .appleFooter a {
            color: #999999;
            text-decoration: none;
        }

        /* MOBILE STYLES */
        @media screen and (max-width: 525px) {

            /* ALLOWS FOR FLUID TABLES */
            table[class="wrapper"] {
                width: 100% !important;
                min-width: 0px !important;
            }

            /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
            td[class="mobile-hide"] {
                display: none;
            }

            img[class="mobile-hide"] {
                display: none !important;
            }

            img[class="img-max"] {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            /* FULL-WIDTH TABLES */
            table[class="responsive-table"] {
                width: 100% !important;
            }

            /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
            td[class="padding"] {
                padding: 10px 5% 15px 5% !important;
            }

            td[class="padding-copy"] {
                padding: 10px 5% 10px 5% !important;
                text-align: center;
            }

            td[class="padding-meta"] {
                padding: 30px 5% 0px 5% !important;
                text-align: center;
            }

            td[class="no-pad"] {
                padding: 0 0 0px 0 !important;
            }

            td[class="no-padding"] {
                padding: 0 !important;
            }

            td[class="section-padding"] {
                padding: 10px 15px 10px 15px !important;
            }

            td[class="section-padding-bottom-image"] {
                padding: 10px 15px 0 15px !important;
            }

            /* ADJUST BUTTONS ON MOBILE */
            td[class="mobile-wrapper"] {
                padding: 10px 5% 15px 5% !important;
            }

            table[class="mobile-button-container"] {
                margin: 0 auto;
                width: 100% !important;
            }

            a[class="mobile-button"] {
                width: 80% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 16px !important;
            }

        }
    </style>
</head>
<body style="margin: 0; padding: 0;" bgcolor="#ffffff" align="center">

@include("emails.parts.vendor.preheader")
@include("emails.parts.vendor.header")

@yield("message_block")

@yield("message_cartitems")

@yield("message_footer")

@include("emails.parts.vendor.footer")
<script type='text/javascript' src="{{asset('js/currencyFormatter.js')}}"></script>

<script>
        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money',
                currency: 'CNY',
                symbol: '元',
                pattern: '#,##0!;(-#,##0!);0!'
            });
        OSREC.CurrencyFormatter.formatAll(
            {
                selector: '.money_jp',
                currency: 'JPY',
                symbol: '円',
                pattern: '#,##0!;(-#,##0!);0!'
            });
</script>
</body>
</html>
