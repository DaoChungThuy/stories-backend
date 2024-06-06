<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title></title>
    <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]-->
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
    <!--[if gte mso 9]>
<xml>
    <o:OfficeDocumentSettings>
    <o:AllowPNG></o:AllowPNG>
    <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
</xml>
<![endif]-->
</head>

<body>
    <div dir="ltr" class="es-wrapper-color">
        <!--[if gte mso 9]>
   <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
    <v:fill type="tile" color="#ffffff"></v:fill>
   </v:background>
  <![endif]-->
        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td class="esd-email-paddings" valign="top">
                        <table class="es-content esd-header-popover" align="center" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" align="center" width="600" cellspacing="0"
                                            cellpadding="0" bgcolor="#ffffff">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p20t" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" align="center"
                                                                        width="600" valign="top">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-image es-p20r es-p20l"
                                                                                        align="center"
                                                                                        style="font-size: 0px;">
                                                                                        <a target="_blank">
                                                                                            <img class="adapt-img"
                                                                                                src="../../../public/cover.png"
                                                                                                alt="Image"
                                                                                                style="display: block;"
                                                                                                title="Image"
                                                                                                height="240">
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="es-content" align="center" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body"
                                            style="border-left:1px solid transparent;border-right:1px solid transparent;border-top:1px solid transparent;border-bottom:1px solid transparent;"
                                            align="center" width="600" cellspacing="0" cellpadding="0"
                                            bgcolor="#ffffff">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p20t es-p40b es-p40r es-p40l"
                                                        align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" align="left"
                                                                        width="518">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-m-txt-c"
                                                                                        align="center">
                                                                                        <h2>Hey
                                                                                            {{-- {{ $data['name'] }}!<br> --}}
                                                                                            To activate your account
                                                                                            please click the button
                                                                                            below
                                                                                        </h2>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-button es-p20t es-p15b es-p10r es-p10l"
                                                                                        align="center">
                                                                                        <span class="es-button-border"
                                                                                            style="
                                                                                            display: block;
                                                                                            padding: 1rem 1.5rem;
                                                                                            background-color: grey;
                                                                                            color: white;
                                                                                            text-decoration: none;
                                                                                            width: fit-content;
                                                                                            border-radius: 50px;
                                                                                            cursor: pointer;
                                                                                        ">
                                                                                            <a style="text-decoration: none;
                                                                                                cursor: auto;
                                                                                                color: white;
                                                                                                font-size: 2rem;"
                                                                                                {{-- href="{{ route('vertifyEmailForUser', ['token' => $data]) }}" --}}
                                                                                                href="{{ 'http://127.0.0.1:8000/api/user/vertify/' . $data }}"
                                                                                                class="es-button">
                                                                                                Vertify
                                                                                            </a>
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- <table cellpadding="0" cellspacing="0" class="es-footer esd-footer-popover" align="center"
                            style="margin-top:1rem">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" style="background-color: #f7f7f7;" bgcolor="#f7f7f7"
                                        align="center">
                                        <table class="es-footer-body" width="600" cellspacing="0" cellpadding="0"
                                            align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p20t es-p20b es-p20r es-p20l"
                                                        esd-general-paddings-checked="false" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="560"
                                                                        valign="top" align="center">
                                                                        <table width="100%" cellspacing="0"
                                                                            cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text es-p5b"
                                                                                        align="center">
                                                                                        <h3 style="line-height: 150%;">
                                                                                            You are late for the task
                                                                                        </h3>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table> --}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="position: absolute; left: -9999px; top: -9999px; margin: 0px;"></div>
</body>

</html>
