# KIMI Portal - Folder Structure

Source: `src/original-src/web/` (copied from `docs/02-Kimi-portal-innowise-archive/KIMI-Portal/web/`)

```
src/web-original/
├── exchange/                           (batch file exchange dirs, one per campaign_id)
│   ├── 1/
│   │   ├── IN/                         (empty)
│   │   └── OUT/                        (empty)
│   ├── 2/
│   │   ├── IN/                         (empty)
│   │   ├── OUT/                        (empty)
│   │   └── INKO2016_OUTBOUND_ELSBETH_inA20240725035731.csv
│   ├── 3/
│   │   ├── IN/                         (empty)
│   │   └── OUT/                        (empty)
│   ├── 16/
│   │   ├── IN/                         (empty)
│   │   └── OUT/                        (empty)
│   ├── 18/
│   │   ├── IN/                         (empty)
│   │   └── OUT/                        (empty)
│   ├── 24/
│   │   ├── IN/                         (empty)
│   │   └── OUT/                        (empty)
│   ├── 27/
│   │   ├── IN/                         (empty)
│   │   └── OUT/                        (empty)
│   ├── 40/
│   │   ├── IN/                         (empty)
│   │   └── OUT/                        (empty)
│   ├── 41/
│   │   ├── IN/                         (empty)
│   │   └── OUT/                        (empty)
│   └── 43/
│       ├── IN/                         (empty)
│       └── OUT/                        (empty)
├── files/                              (empty)
├── htdocs/
│   ├── adminer-4.8.1.php               (DB admin tool)
│   ├── index.php                       (public landing page)
│   ├── css/
│   │   ├── default.css
│   │   ├── default-Lantargo.css
│   │   ├── nivo-slider.css
│   │   ├── theme-modern.css
│   │   ├── kimi-blue/
│   │   │   ├── jquery-ui-1.10.3.custom.css
│   │   │   ├── jquery-ui-1.10.3.custom.min.css
│   │   │   └── images/
│   │   │       ├── animated-overlay.gif
│   │   │       ├── ui-bg_diagonals-thick_18_b81900_40x40.png
│   │   │       ├── ui-bg_diagonals-thick_20_666666_40x40.png
│   │   │       ├── ui-bg_flat_10_000000_40x100.png
│   │   │       ├── ui-bg_flat_100_57d1ff_40x100.png
│   │   │       ├── ui-bg_glass_65_ffffff_1x400.png
│   │   │       ├── ui-bg_highlight-soft_100_eeeeee_1x100.png
│   │   │       ├── ui-bg_highlight-soft_100_f6f6f6_1x100.png
│   │   │       ├── ui-bg_highlight-soft_35_00b0f1_1x100.png
│   │   │       ├── ui-bg_highlight-soft_75_01b0f1_1x100.png
│   │   │       ├── ui-icons_01b0f1_256x240.png
│   │   │       ├── ui-icons_222222_256x240.png
│   │   │       ├── ui-icons_228ef1_256x240.png
│   │   │       ├── ui-icons_ffd27a_256x240.png
│   │   │       └── ui-icons_ffffff_256x240.png
│   │   ├── kimi-blue-modern/
│   │   │   ├── jquery-ui-1.10.3.custom.css
│   │   │   ├── jquery-ui-1.10.3.custom.min.css
│   │   │   └── images/
│   │   │       ├── animated-overlay.gif
│   │   │       ├── ui-bg_diagonals-thick_18_b81900_40x40.png
│   │   │       ├── ui-bg_diagonals-thick_20_666666_40x40.png
│   │   │       ├── ui-bg_flat_10_000000_40x100.png
│   │   │       ├── ui-bg_flat_100_ceddfd_40x100.png
│   │   │       ├── ui-bg_flat_75_5cbbff_40x100.png
│   │   │       ├── ui-bg_glass_100_f6f6f6_1x400.png
│   │   │       ├── ui-bg_highlight-soft_100_eeeeee_1x100.png
│   │   │       ├── ui-bg_highlight-soft_35_2885f6_1x100.png
│   │   │       ├── ui-bg_highlight-soft_65_ffffff_1x100.png
│   │   │       ├── ui-icons_0850ef_256x240.png
│   │   │       ├── ui-icons_0855ef_256x240.png
│   │   │       ├── ui-icons_0872ef_256x240.png
│   │   │       ├── ui-icons_222222_256x240.png
│   │   │       ├── ui-icons_228ef1_256x240.png
│   │   │       ├── ui-icons_ffd27a_256x240.png
│   │   │       └── ui-icons_ffffff_256x240.png
│   │   ├── kimi-green/
│   │   │   ├── jquery-ui-1.10.3.custom.css
│   │   │   ├── jquery-ui-1.10.3.custom.min.css
│   │   │   └── images/
│   │   │       ├── animated-overlay.gif
│   │   │       ├── ui-bg_diagonals-thick_18_b81900_40x40.png
│   │   │       ├── ui-bg_diagonals-thick_20_666666_40x40.png
│   │   │       ├── ui-bg_flat_10_000000_40x100.png
│   │   │       ├── ui-bg_flat_100_d0eac9_40x100.png
│   │   │       ├── ui-bg_glass_100_f6f6f6_1x400.png
│   │   │       ├── ui-bg_highlight-soft_100_eeeeee_1x100.png
│   │   │       ├── ui-bg_highlight-soft_35_549e3f_1x100.png
│   │   │       ├── ui-bg_highlight-soft_65_ffffff_1x100.png
│   │   │       ├── ui-bg_highlight-soft_75_ffe45c_1x100.png
│   │   │       ├── ui-icons_222222_256x240.png
│   │   │       ├── ui-icons_228ef1_256x240.png
│   │   │       ├── ui-icons_417134_256x240.png
│   │   │       ├── ui-icons_508142_256x240.png
│   │   │       ├── ui-icons_508241_256x240.png
│   │   │       ├── ui-icons_ffd27a_256x240.png
│   │   │       └── ui-icons_ffffff_256x240.png
│   │   └── slider-theme/
│   │       └── default.css
│   ├── images/
│   │   ├── franz.jpg
│   │   ├── hackerl.jpg
│   │   ├── KiMi_Logo.JPG
│   │   ├── KiMi_Logo.PNG
│   │   ├── KIMIPlus.PNG
│   │   ├── logo-facebook.gif
│   │   ├── logo-xing.gif
│   │   ├── telephone.png
│   │   ├── Thumbs.db
│   │   ├── partners/
│   │   │   ├── itandtel.JPG
│   │   │   ├── KIMI_CS.JPG
│   │   │   ├── planio.JPG
│   │   │   └── W4Y.JPG
│   │   ├── portal/
│   │   │   ├── delete.png
│   │   │   ├── delete16x16.png
│   │   │   ├── pencil.png
│   │   │   └── pencil16x16.png
│   │   ├── services/
│   │   │   ├── PH.JPG
│   │   │   ├── PM.JPG
│   │   │   ├── PO.JPG
│   │   │   ├── PP.JPG
│   │   │   └── SO.JPG
│   │   ├── slider-theme/
│   │   │   ├── arrows.png
│   │   │   ├── bullets.png
│   │   │   ├── loading.gif
│   │   │   └── Thumbs.db
│   │   ├── slides/
│   │   │   ├── asdf.jpg
│   │   │   ├── Fotolia_24050343_S.jpg
│   │   │   ├── Fotolia_27457408_S.jpg
│   │   │   ├── Fotolia_40755062_S.jpg
│   │   │   ├── Fotolia_48706840_S.jpg
│   │   │   ├── Fotolia_50034786_S.jpg
│   │   │   ├── Fotolia_50437857_S.jpg
│   │   │   ├── Fotolia_51102765_S.jpg
│   │   │   ├── Fotolia_53004851_S.jpg
│   │   │   ├── Fotolia_53597186_S.jpg
│   │   │   ├── p1.jpg
│   │   │   ├── p2.jpg
│   │   │   ├── p3.jpg
│   │   │   ├── p4.jpg
│   │   │   ├── p5.jpg
│   │   │   ├── p6.jpg
│   │   │   ├── p7.jpg
│   │   │   └── Thumbs.db
│   │   └── theme-modern/
│   │       ├── arrow_kontakt_icon.png
│   │       ├── bg_gradient_home_top.png
│   │       ├── bg_texture.png
│   │       ├── btn_arrow_icon.png
│   │       ├── btn_arrow_icon_back.png
│   │       ├── btn_left.png
│   │       ├── btn_middle.png
│   │       ├── btn_right.png
│   │       ├── customer_services_icon.png
│   │       ├── der_liebe_franz.png
│   │       ├── facebook_icon.png
│   │       ├── header_bg.png
│   │       ├── header_bg_left.png
│   │       ├── header_bg_middle.png
│   │       ├── header_bg_right.png
│   │       ├── impressum_icon.png
│   │       ├── kimi_news_icon.png
│   │       ├── kimi_plus_logo_home.png
│   │       ├── kimi-plus_logo_nav.png
│   │       ├── kontakt_icon.png
│   │       ├── logout_icon.png
│   │       ├── partner_itandtel.png
│   │       ├── partner_kimi_customer_service.png
│   │       ├── partner_planio.png
│   │       ├── projekte_prozesse_icon.png
│   │       ├── projekt_helpdesk_icon.png
│   │       ├── projekt_managment_icon.png
│   │       ├── projekt_office_icon.png
│   │       ├── projekt_plattform_icon.png
│   │       ├── seperator_shadow.png
│   │       ├── services_icon.png
│   │       ├── slider_arrow_left.png
│   │       ├── slider_arrow_right.png
│   │       ├── software_services_icon.png
│   │       ├── Thumbs.db
│   │       ├── tick_icon.png
│   │       ├── tool_tip_bg.png
│   │       ├── user_icon.png
│   │       ├── wko.gif
│   │       └── xing_icon.png
│   ├── lib/
│   │   ├── jquery.js
│   │   ├── jquery-ui.js
│   │   ├── jquery.nivo.slider.pack.js
│   │   └── jquery.placeholder.js
│   ├── vendor/
│   │   ├── autoload.php
│   │   ├── composer/
│   │   │   ├── autoload_classmap.php
│   │   │   ├── autoload_namespaces.php
│   │   │   ├── autoload_psr4.php
│   │   │   ├── autoload_real.php
│   │   │   ├── autoload_static.php
│   │   │   ├── ClassLoader.php
│   │   │   ├── installed.json
│   │   │   ├── installed.php
│   │   │   ├── InstalledVersions.php
│   │   │   ├── LICENSE
│   │   │   └── platform_check.php
│   │   └── phpmailer/
│   │       └── phpmailer/
│   │           ├── src/
│   │           │   ├── Exception.php
│   │           │   ├── OAuth.php
│   │           │   ├── PHPMailer.php
│   │           │   ├── POP3.php
│   │           │   └── SMTP.php
│   │           ├── language/           (55 phpmailer.lang-*.php locale files)
│   │           ├── get_oauth_token.php
│   │           ├── composer.json
│   │           ├── COMMITMENT
│   │           ├── LICENSE
│   │           ├── README.md
│   │           ├── SECURITY.md
│   │           └── VERSION
│   └── kimi_ET/                        (main application root)
│       ├── adminer-4.8.1.php           (DB admin tool, duplicate)
│       ├── getticketurl.php
│       ├── index.php                   (app entry point)
│       ├── kimi_login.html
│       ├── login.php
│       ├── phpinfo.php
│       ├── setticketcallinfo.php
│       ├── testpost.php
│       ├── validphone.php
│       ├── xhangup.php
│       ├── ajax/                       (AJAX endpoints for telephony integration)
│       │   ├── add_log.php
│       │   ├── callInntelco.php
│       │   ├── check-login.php
│       │   ├── write_file.php
│       │   ├── config/
│       │   │   ├── config.php
│       │   │   ├── config.php.old
│       │   │   └── lang/
│       │   │       ├── de.php
│       │   │       ├── de_sich.php
│       │   │       ├── de_sich_20150208.php
│       │   │       └── en.old.php
│       │   └── log/
│       │       ├── callinfo.log
│       │       ├── callInntelco.log
│       │       ├── callTelematica.log
│       │       └── telematica_import_callmanager_log_error.log
│       ├── config/                     (main app config, mirrors ajax/config/)
│       │   ├── config.php
│       │   ├── config.php.old
│       │   └── lang/
│       │       ├── de.php
│       │       ├── de_sich.php
│       │       ├── de_sich_20150208.php
│       │       └── en.old.php
│       ├── css/                        (empty)
│       ├── ical/                       (empty)
│       ├── js/
│       │   ├── jquery.js
│       │   └── jquery-ui.js
│       ├── kimibatch/                  (batch processing scripts per client/campaign)
│       │   ├── db.php                  (shared DB helper)
│       │   ├── kimi_general.php        (shared batch utilities)
│       │   ├── kimi_general_sql.php
│       │   ├── kimibatchtree.php       (batch script browser/overview)
│       │   ├── kimiphpinfo.php
│       │   ├── phpinfo.php
│       │   ├── pwgen.php
│       │   ├── pos30cc.txt
│       │   ├── substr.php
│       │   ├── wl.php
│       │   ├── zeichenersetzen.php
│       │   ├── inboundoutboundrep.php
│       │   ├── inboundoutboundrepx.php
│       │   ├── telematica_import_callmanager_log.php
│       │   │
│       │   │   — COEO campaign (campaign_id 43) —
│       │   ├── coeo01_import_telefonie_taeglich.php
│       │   ├── coeo01_import_telnr_optimierung.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_alle.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_l2tage.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_l2tage_klarna.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_l2tage_raten.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_l3tage.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_l3tage_klarna.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_l3tage_raten.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_neue.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_nicht_klarna.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_nur_klarna.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_import_telefonnrfalsch.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_RATENERINNERUNG_import.php
│       │   ├── coeo02_tagl_daten_fuer_elsbeth_SONDERKAMPAGNE_import.php
│       │   ├── coeo03_verarbeitung_elsbeth_out.php
│       │   ├── COEO_NeueMandanten20230523.pdf
│       │   │
│       │   │   — COEO-CH variant —
│       │   ├── coeoch01_import_telefonie_taeglich.php
│       │   ├── coeoch01_import_telnr_optimierung.php
│       │   ├── coeoch02_tagl_daten_fuer_elsbeth_import.php
│       │   ├── coeoch03_verarbeitung_elsbeth_out.php
│       │   ├── coeochcheck.php
│       │   ├── coeochchecktest.php
│       │   ├── coeochreport.php
│       │   ├── coeochschnupd.php
│       │   │
│       │   │   — COEO-CH-DE variant —
│       │   ├── coeochde02_tagl_daten_fuer_elsbeth_import_alle.php
│       │   ├── coeochde02_tagl_daten_fuer_elsbeth_import_neue.php
│       │   ├── coeochdeexp.php
│       │   ├── coeochdeexptest.php
│       │   ├── coeochdeexpx.php
│       │   │
│       │   │   — COEO-DREI variant —
│       │   ├── coeodrei01_import_telefonie_taeglich.php
│       │   ├── coeodrei01_import_telnr_optimierung.php
│       │   ├── coeodrei02_tagl_daten_fuer_elsbeth_import.php
│       │   ├── coeodrei02_tagl_daten_fuer_elsbeth_import_alle.php
│       │   ├── coeodrei02_tagl_daten_fuer_elsbeth_import_neue.php
│       │   ├── coeodrei03_verarbeitung_elsbeth_out.php
│       │   ├── coeodreicheck.php
│       │   ├── coeodreichecktest.php
│       │   ├── coeodreireport.php
│       │   ├── coeodreischnupd.php
│       │   │
│       │   │   — INKO 2016 campaign —
│       │   ├── inko201601_daten_inA_fuer_elsbeth_import.php
│       │   ├── inko201602_daten_off_fuer_elsbeth_import.php
│       │   ├── inko201603_verarbeitung_elsbeth_out.php
│       │   ├── inko201604_status_offen_auf_inA_setzen.php
│       │   ├── inko201605_daten_email_fuer_elsbeth_import.php
│       │   ├── inko201605_update_ratenhinweise.php
│       │   ├── inko2016check.php
│       │   ├── inko2016email1ktoexp.php
│       │   ├── inko2016email2zvexp.php
│       │   ├── inko2016email3zwexp.php
│       │   ├── inko2016exp.php
│       │   ├── inko2016imp3.php
│       │   ├── inko2016report.php
│       │   ├── inko2016schnupd.php
│       │   ├── inko2016sepaexp.php
│       │   ├── inko2016doku.pdf
│       │   ├── INKO20220627.pdf
│       │   │
│       │   │   — INKO-DE variant —
│       │   ├── inkode01_daten_inA_fuer_elsbeth_import.php
│       │   ├── inkode02_daten_off_fuer_elsbeth_import.php
│       │   ├── inkode03_verarbeitung_elsbeth_out.php
│       │   ├── inkode04_status_offen_auf_inA_setzen.php
│       │   ├── inkode05_daten_email_fuer_elsbeth_import.php
│       │   ├── inkode05_update_ratenhinweise.php
│       │   ├── inkodecheck.php
│       │   ├── inkodeemail1ktoexp.php
│       │   ├── inkodeemail2zvexp.php
│       │   ├── inkodeemail3zwexp.php
│       │   ├── inkodeexp.php
│       │   ├── inkodeexp_new.php
│       │   ├── inkodeimp2.php
│       │   ├── inkodeimp2x.php
│       │   ├── inkodereport.php
│       │   ├── inkodeschnupd.php
│       │   ├── inkodesepaexp.php
│       │   ├── inkode.pdf
│       │   │
│       │   │   — INKO SEPA —
│       │   ├── inkosepaexp.php
│       │   ├── inkoseparep.php
│       │   ├── inkoinboundreport.php
│       │   ├── INKOSEPA.pdf
│       │   │
│       │   │   — KNP1 campaign —
│       │   ├── knp1check.php
│       │   ├── knp1checktest.php
│       │   ├── knp1report.php
│       │   ├── knp1schnupd.php
│       │   │
│       │   │   — KPI reporting —
│       │   ├── kpis.php
│       │   ├── kpiscsv.php
│       │   ├── kpisemail.php
│       │   ├── kpisemailtest.php
│       │   │
│       │   │   — OKO campaign —
│       │   ├── oko01_daten_inA_fuer_elsbeth_import.php
│       │   ├── oko01_daten_inA_fuer_elsbeth_import_telefon1.php
│       │   ├── oko01_daten_inA_fuer_elsbeth_import_telefon2.php
│       │   ├── oko01_daten_inA_fuer_elsbeth_import_telefon3.php
│       │   ├── oko01_daten_inA_fuer_elsbeth_import_telefon4.php
│       │   ├── oko02_daten_off_fuer_elsbeth_import.php
│       │   ├── oko03_verarbeitung_elsbeth_out.php
│       │   ├── oko04_mehrfach_tickets_anzeigen.php
│       │   ├── oko04_status_offen_auf_inA_setzen.php
│       │   ├── oko04_status_offen_vortage_auf_inA_setzen.php
│       │   ├── okocheck.php
│       │   ├── okoexp.php
│       │   ├── okoexp_ansi.php
│       │   ├── okoexp_ansi2.php
│       │   ├── okoexp_ansi-roni.php
│       │   ├── okoexp_dev.php
│       │   ├── okoexpzwb.php
│       │   ├── okoimp.php
│       │   ├── oko_inA_outbound_elsbeth.php
│       │   ├── okoreport.php
│       │   ├── okoschnupd.php
│       │   ├── OKO_Leitfaden.pdf
│       │   ├── OKO_Leitfaden_20220627.pdf
│       │   ├── OKO_Protokoll-Export.docx
│       │   ├── OKO_SachbearbeiterNEU.pdf
│       │   │
│       │   │   — Schlaustrom campaign —
│       │   ├── schlaustrom01_daten_inA_fuer_elsbeth_import.php
│       │   ├── schlaustrom01_import_telefonie_taeglich.php
│       │   ├── schlaustrom01SONDER_daten_inA_fuer_elsbeth_import.php
│       │   ├── schlaustrom02_daten_off_fuer_elsbeth_import.php
│       │   ├── schlaustrom03_verarbeitung_elsbeth_out.php
│       │   ├── schlaustromcheck.php
│       │   ├── schlaustromexp20190924.php
│       │   ├── schlaustromexp20220703.php
│       │   ├── schlaustromreport.php
│       │   ├── schlaustromschnupd.php
│       │   ├── SCHLAUSTROM_LEITFADEN.pdf
│       │   │
│       │   │   — Misc / one-off —
│       │   ├── questerexp20250208.php
│       │   │
│       │   └── files/                  (per-campaign SQL scripts, data files, config)
│       │       ├── 16/
│       │       │   └── Scripts/        (21 files: .sql, .php, .pdf)
│       │       ├── 18/
│       │       │   └── Scripts/        (11 .sql files)
│       │       ├── 24/
│       │       │   └── Scripts/        (12 .sql files)
│       │       ├── 27/
│       │       │   └── Scripts/        (24 .sql files)
│       │       ├── 40/
│       │       │   └── Scripts/        (37 .sql files)
│       │       ├── 41/
│       │       │   └── Scripts/        (48 .sql files)
│       │       ├── 43/
│       │       │   ├── Scripts/
│       │       │   │   ├── Save/       (13 .sql backup files)
│       │       │   │   └── (64 .sql files: sberbank_*, coeo_*, inko_*)
│       │       │   ├── Services/       (15 .txt service definition files)
│       │       │   └── Templates/      (10 .html/.txt email & SMS templates)
│       │       ├── 20240606/           (5 .csv data files)
│       │       ├── css/                (copy of htdocs/css jQuery UI themes)
│       │       │   ├── kimi-blue/      (same contents as htdocs/css/kimi-blue/)
│       │       │   ├── kimi-blue-modern/
│       │       │   ├── kimi-green/
│       │       │   └── slider-theme/
│       │       ├── save/
│       │       │   ├── pos30cc.txt
│       │       │   └── filesx/
│       │       │       └── 40/
│       │       │           └── Scripts/  (empty)
│       │       └── vendor/             (copy of htdocs/vendor: Composer + PHPMailer)
│       ├── libs/                       (core framework)
│       │   ├── application.php         (MVC bootstrapper / request router)
│       │   ├── database.php            (PDO wrapper)
│       │   ├── init.php                (app initialisation)
│       │   ├── SCB.CSV                 (data file)
│       │   ├── addons/
│       │   │   └── phpmail/            (legacy PHPMailer v5 wrapper)
│       │   │       ├── class.phpmailer.php
│       │   │       ├── class.smtp.php
│       │   │       ├── send_test.php
│       │   │       └── send_ticket_mail.php
│       │   └── entities/               (one PHP class per DB entity)
│       │       ├── akt.php
│       │       ├── anrede.php
│       │       ├── anrufzeiten.php
│       │       ├── anstoss.php
│       │       ├── ausbuchungsgrund.php
│       │       ├── bankleitzahl.php
│       │       ├── benutzer.php
│       │       ├── buchungen.php
│       │       ├── buchungsart.php
│       │       ├── buchungsgrund.php
│       │       ├── country.php
│       │       ├── customer.php
│       │       ├── erled_qual.php
│       │       ├── inkassoinformation.php
│       │       ├── inkassostatus.php
│       │       ├── kampagne.php
│       │       ├── kategorie.php
│       │       ├── kundenhistorie.php
│       │       ├── lastschrift.php
│       │       ├── log.php
│       │       ├── mandant.php
│       │       ├── menu_item.php
│       │       ├── permission.php
│       │       ├── portal_text.php
│       │       ├── prioritaet.php
│       │       ├── ra_ikbuero.php
│       │       ├── ratenrechner.php
│       │       ├── role.php
│       │       ├── schadensfall.php
│       │       ├── schadensfall_art.php
│       │       ├── stammdaten.php
│       │       ├── status_schadensfall.php
│       │       ├── subkonto.php
│       │       ├── subkonto_1.php
│       │       ├── subkonto_s.php
│       │       ├── text.php
│       │       ├── ticket.php
│       │       ├── ticket_historie.php
│       │       ├── ticket_sich20150208.php
│       │       ├── titel.php
│       │       ├── user.php
│       │       ├── user_sich20150208.php
│       │       ├── versicherung.php
│       │       ├── verwaltungssatz.php
│       │       ├── zahlart.php
│       │       └── php_errors.log
│       └── modules/                    (UI controllers)
│           ├── subkonto.php
│           ├── gui/                    (active GUI module)
│           │   ├── 404.php
│           │   ├── akt.php
│           │   ├── akt_validate.js
│           │   ├── kampauswahl.php
│           │   ├── logout.php
│           │   ├── menu_verw.php
│           │   ├── np.php
│           │   ├── portal.php
│           │   ├── pwgen.php
│           │   ├── ticket.php
│           │   ├── ticket2.php
│           │   ├── ticket_sich.php
│           │   ├── ticketsuch.php
│           │   ├── ticketsuch2.php
│           │   ├── old_delete/         (18 superseded PHP files, kept for reference)
│           │   │   ├── bankleitzahl.php
│           │   │   ├── buchungen.php
│           │   │   ├── inkassoinformation.php
│           │   │   ├── kunde.php
│           │   │   ├── kunde_details.php
│           │   │   ├── kundenhistorie.php
│           │   │   ├── lastschrift.php
│           │   │   ├── ratenrechner.php
│           │   │   ├── schadensfall.php
│           │   │   ├── schadensfall_art.php
│           │   │   ├── stammdaten.php
│           │   │   ├── stammsuche.php
│           │   │   ├── status_schadensfall.php
│           │   │   ├── subdetail.php
│           │   │   ├── subsuche.php
│           │   │   ├── subuebersicht.php
│           │   │   ├── subverwalt.php
│           │   │   └── versicherung.php
│           │   └── templates/
│           │       └── tickets/        (per-campaign ticket UI templates)
│           │           ├── 1/
│           │           │   ├── ticket.php
│           │           │   ├── ticketsuch.php
│           │           │   ├── ticketuebersicht.php
│           │           │   ├── ticketoptimize.js
│           │           │   ├── ticketvalidate.js
│           │           │   └── knpdoku.pdf
│           │           ├── 2/
│           │           │   ├── ticket.php
│           │           │   ├── ticketsuch.php
│           │           │   ├── ticketuebersicht.php
│           │           │   ├── ticketoptimize.js
│           │           │   ├── ticketoptimize_save20230503.js
│           │           │   ├── ticketvalidate.js
│           │           │   └── knpdoku.pdf
│           │           ├── 3/
│           │           │   ├── ticket.php
│           │           │   ├── ticketsuch.php
│           │           │   ├── ticketuebersicht.php
│           │           │   ├── ticketoptimize.js
│           │           │   └── ticketvalidate.js
│           │           ├── 8/
│           │           │   ├── ticket.php
│           │           │   ├── ticketsuch.php
│           │           │   ├── ticketuebersicht.php
│           │           │   ├── ticketoptimize.js
│           │           │   └── ticketvalidate.js
│           │           ├── 10/
│           │           │   ├── ticket.php
│           │           │   ├── ticketsuch.php
│           │           │   ├── ticketuebersicht.php
│           │           │   ├── ticketoptimize.js
│           │           │   └── ticketvalidate.js
│           │           ├── 16/
│           │           │   ├── ticket.php
│           │           │   ├── ticketsuch.php
│           │           │   ├── ticketuebersicht.php
│           │           │   ├── ticketoptimize.js
│           │           │   ├── ticketvalidate.js
│           │           │   └── Microsoft Word - Mitarbeiterinfo-Kurzfassung_Projekt_InkoDE.pdf
│           │           ├── 19/
│           │           │   ├── ticket.php
│           │           │   ├── ticketsuch.php
│           │           │   ├── ticketuebersicht.php
│           │           │   ├── ticketoptimize.js
│           │           │   ├── ticketvalidate.js
│           │           │   ├── ticketvalidate - Save.js
│           │           │   ├── ticketvalidatex.js
│           │           │   ├── ifsschnupd.php
│           │           │   └── knpdoku.pdf
│           │           ├── 34/
│           │           │   ├── ticket.php
│           │           │   ├── ticketsuch.php
│           │           │   ├── ticketuebersicht.php
│           │           │   ├── ticketoptimize.js
│           │           │   ├── ticketvalidate.js
│           │           │   └── knpdoku.pdf
│           │           └── 35/
│           │               ├── ticket.php
│           │               ├── ticketsuch.php
│           │               ├── ticketuebersicht.php
│           │               ├── ticketoptimize.js
│           │               ├── ticketvalidate.js
│           │               └── knpdoku.pdf
│           ├── initial/                (⚠ no longer active — legacy versions of menu/ pages)
│           │   ├── akt.php
│           │   ├── bankleitzahl.php
│           │   ├── buchungen.php
│           │   ├── inkassoinformation.php
│           │   ├── kampauswahl.php
│           │   ├── kunde.php
│           │   ├── kunde_details.php
│           │   ├── kundenhistorie.php
│           │   ├── lastschrift.php
│           │   ├── logout.php
│           │   ├── menu_verw.php
│           │   ├── portal.php
│           │   ├── pwgen.php
│           │   ├── ratenrechner.php
│           │   ├── schadensfall.php
│           │   ├── schadensfall_art.php
│           │   ├── stammdaten.php
│           │   ├── stammsuche.php
│           │   ├── status_schadensfall.php
│           │   ├── subdetail.php
│           │   ├── subsuche.php
│           │   ├── subuebersicht.php
│           │   ├── subverwalt.php
│           │   ├── ticket.php
│           │   ├── ticket2.php
│           │   ├── ticket_sich20150208.php
│           │   ├── ticketsuch.php
│           │   ├── ticketsuch2.php
│           │   ├── ticketsuch_sich20150208.php
│           │   └── versicherung.php
│           └── menu/                   (active menu/data management pages)
│               ├── bankleitzahl.php
│               ├── buchungen.php
│               ├── inkassoinformation.php
│               ├── kunde.php
│               ├── kunde_details.php
│               ├── kundenhistorie.php
│               ├── lastschrift.php
│               ├── menu_verw.php
│               ├── portal.php
│               ├── ratenrechner.php
│               ├── schadensfall.php
│               ├── schadensfall_art.php
│               ├── stammdaten.php
│               ├── stammsuche.php
│               ├── status_schadensfall.php
│               ├── subdetail.php
│               ├── subsuche.php
│               ├── subuebersicht.php
│               ├── subverwalt.php
│               ├── ticket.php
│               ├── ticket2.php
│               ├── ticketsuch.php
│               ├── ticketsuch2.php
│               ├── ticketsuch_sich20150208.php
│               └── versicherung.php
├── logs/                               (empty)
└── tmp/
    ├── adminer.invalid
    └── adminer.version
```