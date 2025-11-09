## Estructura del proyecto

```
Administrador_IFTS/
│
├── _db_backups/
│   │   └── dump-adl_admin_inscripcion-20251028.sql
├── assets/
│   ├── css/
│   │   │   └── estilo.css
│   │   │   └── login.css
│   ├── img/
│   │   │   └── Adolescentes.png
│   ├── js/
├── crud_actividades/
│   │   └── alta.php
│   │   └── baja.php
│   │   └── editar.php
│   │   └── listar.php
├── crud_adolescentes/
│   │   └── alta.php
│   │   └── baja.php
│   │   └── editar.php
│   │   └── listar.php
├── crud_instituciones/
│   │   └── alta.php
│   │   └── baja.php
│   │   └── editar.php
│   │   └── listar.php
├── includes/
│   │   └── footer.php
│   │   └── header.php
│   │   └── sidebar.php
├── libs/
│   ├── tcpdf/
│   │   ├── config/
│   │   │   │   └── tcpdf_config.php
│   │   ├── fonts/
│   │   │   ├── ae_fonts_2.0/
│   │   │   │   │   └── COPYING
│   │   │   │   │   └── ChangeLog
│   │   │   │   │   └── README
│   │   │   ├── dejavu-fonts-ttf-2.33/
│   │   │   │   │   └── AUTHORS
│   │   │   │   │   └── BUGS
│   │   │   │   │   └── LICENSE
│   │   │   │   │   └── NEWS
│   │   │   │   │   └── README
│   │   │   │   │   └── langcover.txt
│   │   │   │   │   └── unicover.txt
│   │   │   ├── dejavu-fonts-ttf-2.34/
│   │   │   │   │   └── AUTHORS
│   │   │   │   │   └── BUGS
│   │   │   │   │   └── LICENSE
│   │   │   │   │   └── NEWS
│   │   │   │   │   └── README
│   │   │   │   │   └── langcover.txt
│   │   │   │   │   └── unicover.txt
│   │   │   ├── freefont-20100919/
│   │   │   │   │   └── AUTHORS
│   │   │   │   │   └── COPYING
│   │   │   │   │   └── CREDITS
│   │   │   │   │   └── ChangeLog
│   │   │   │   │   └── INSTALL
│   │   │   │   │   └── README
│   │   │   ├── freefont-20120503/
│   │   │   │   │   └── AUTHORS
│   │   │   │   │   └── COPYING
│   │   │   │   │   └── CREDITS
│   │   │   │   │   └── ChangeLog
│   │   │   │   │   └── INSTALL
│   │   │   │   │   └── README
│   │   │   │   │   └── TROUBLESHOOTING
│   │   │   │   │   └── USAGE
│   │   │   │   └── aealarabiya.ctg.z
│   │   │   │   └── aealarabiya.php
│   │   │   │   └── aealarabiya.z
│   │   │   │   └── aefurat.ctg.z
│   │   │   │   └── aefurat.php
│   │   │   │   └── aefurat.z
│   │   │   │   └── cid0cs.php
│   │   │   │   └── cid0ct.php
│   │   │   │   └── cid0jp.php
│   │   │   │   └── cid0kr.php
│   │   │   │   └── courier.php
│   │   │   │   └── courierb.php
│   │   │   │   └── courierbi.php
│   │   │   │   └── courieri.php
│   │   │   │   └── dejavusans.ctg.z
│   │   │   │   └── dejavusans.php
│   │   │   │   └── dejavusans.z
│   │   │   │   └── dejavusansb.ctg.z
│   │   │   │   └── dejavusansb.php
│   │   │   │   └── dejavusansb.z
│   │   │   │   └── dejavusansbi.ctg.z
│   │   │   │   └── dejavusansbi.php
│   │   │   │   └── dejavusansbi.z
│   │   │   │   └── dejavusanscondensed.ctg.z
│   │   │   │   └── dejavusanscondensed.php
│   │   │   │   └── dejavusanscondensed.z
│   │   │   │   └── dejavusanscondensedb.ctg.z
│   │   │   │   └── dejavusanscondensedb.php
│   │   │   │   └── dejavusanscondensedb.z
│   │   │   │   └── dejavusanscondensedbi.ctg.z
│   │   │   │   └── dejavusanscondensedbi.php
│   │   │   │   └── dejavusanscondensedbi.z
│   │   │   │   └── dejavusanscondensedi.ctg.z
│   │   │   │   └── dejavusanscondensedi.php
│   │   │   │   └── dejavusanscondensedi.z
│   │   │   │   └── dejavusansextralight.ctg.z
│   │   │   │   └── dejavusansextralight.php
│   │   │   │   └── dejavusansextralight.z
│   │   │   │   └── dejavusansi.ctg.z
│   │   │   │   └── dejavusansi.php
│   │   │   │   └── dejavusansi.z
│   │   │   │   └── dejavusansmono.ctg.z
│   │   │   │   └── dejavusansmono.php
│   │   │   │   └── dejavusansmono.z
│   │   │   │   └── dejavusansmonob.ctg.z
│   │   │   │   └── dejavusansmonob.php
│   │   │   │   └── dejavusansmonob.z
│   │   │   │   └── dejavusansmonobi.ctg.z
│   │   │   │   └── dejavusansmonobi.php
│   │   │   │   └── dejavusansmonobi.z
│   │   │   │   └── dejavusansmonoi.ctg.z
│   │   │   │   └── dejavusansmonoi.php
│   │   │   │   └── dejavusansmonoi.z
│   │   │   │   └── dejavuserif.ctg.z
│   │   │   │   └── dejavuserif.php
│   │   │   │   └── dejavuserif.z
│   │   │   │   └── dejavuserifb.ctg.z
│   │   │   │   └── dejavuserifb.php
│   │   │   │   └── dejavuserifb.z
│   │   │   │   └── dejavuserifbi.ctg.z
│   │   │   │   └── dejavuserifbi.php
│   │   │   │   └── dejavuserifbi.z
│   │   │   │   └── dejavuserifcondensed.ctg.z
│   │   │   │   └── dejavuserifcondensed.php
│   │   │   │   └── dejavuserifcondensed.z
│   │   │   │   └── dejavuserifcondensedb.ctg.z
│   │   │   │   └── dejavuserifcondensedb.php
│   │   │   │   └── dejavuserifcondensedb.z
│   │   │   │   └── dejavuserifcondensedbi.ctg.z
│   │   │   │   └── dejavuserifcondensedbi.php
│   │   │   │   └── dejavuserifcondensedbi.z
│   │   │   │   └── dejavuserifcondensedi.ctg.z
│   │   │   │   └── dejavuserifcondensedi.php
│   │   │   │   └── dejavuserifcondensedi.z
│   │   │   │   └── dejavuserifi.ctg.z
│   │   │   │   └── dejavuserifi.php
│   │   │   │   └── dejavuserifi.z
│   │   │   │   └── freemono.ctg.z
│   │   │   │   └── freemono.php
│   │   │   │   └── freemono.z
│   │   │   │   └── freemonob.ctg.z
│   │   │   │   └── freemonob.php
│   │   │   │   └── freemonob.z
│   │   │   │   └── freemonobi.ctg.z
│   │   │   │   └── freemonobi.php
│   │   │   │   └── freemonobi.z
│   │   │   │   └── freemonoi.ctg.z
│   │   │   │   └── freemonoi.php
│   │   │   │   └── freemonoi.z
│   │   │   │   └── freesans.ctg.z
│   │   │   │   └── freesans.php
│   │   │   │   └── freesans.z
│   │   │   │   └── freesansb.ctg.z
│   │   │   │   └── freesansb.php
│   │   │   │   └── freesansb.z
│   │   │   │   └── freesansbi.ctg.z
│   │   │   │   └── freesansbi.php
│   │   │   │   └── freesansbi.z
│   │   │   │   └── freesansi.ctg.z
│   │   │   │   └── freesansi.php
│   │   │   │   └── freesansi.z
│   │   │   │   └── freeserif.ctg.z
│   │   │   │   └── freeserif.php
│   │   │   │   └── freeserif.z
│   │   │   │   └── freeserifb.ctg.z
│   │   │   │   └── freeserifb.php
│   │   │   │   └── freeserifb.z
│   │   │   │   └── freeserifbi.ctg.z
│   │   │   │   └── freeserifbi.php
│   │   │   │   └── freeserifbi.z
│   │   │   │   └── freeserifi.ctg.z
│   │   │   │   └── freeserifi.php
│   │   │   │   └── freeserifi.z
│   │   │   │   └── helvetica.php
│   │   │   │   └── helveticab.php
│   │   │   │   └── helveticabi.php
│   │   │   │   └── helveticai.php
│   │   │   │   └── hysmyeongjostdmedium.php
│   │   │   │   └── kozgopromedium.php
│   │   │   │   └── kozminproregular.php
│   │   │   │   └── msungstdlight.php
│   │   │   │   └── pdfacourier.php
│   │   │   │   └── pdfacourier.z
│   │   │   │   └── pdfacourierb.php
│   │   │   │   └── pdfacourierb.z
│   │   │   │   └── pdfacourierbi.php
│   │   │   │   └── pdfacourierbi.z
│   │   │   │   └── pdfacourieri.php
│   │   │   │   └── pdfacourieri.z
│   │   │   │   └── pdfahelvetica.php
│   │   │   │   └── pdfahelvetica.z
│   │   │   │   └── pdfahelveticab.php
│   │   │   │   └── pdfahelveticab.z
│   │   │   │   └── pdfahelveticabi.php
│   │   │   │   └── pdfahelveticabi.z
│   │   │   │   └── pdfahelveticai.php
│   │   │   │   └── pdfahelveticai.z
│   │   │   │   └── pdfasymbol.php
│   │   │   │   └── pdfasymbol.z
│   │   │   │   └── pdfatimes.php
│   │   │   │   └── pdfatimes.z
│   │   │   │   └── pdfatimesb.php
│   │   │   │   └── pdfatimesb.z
│   │   │   │   └── pdfatimesbi.php
│   │   │   │   └── pdfatimesbi.z
│   │   │   │   └── pdfatimesi.php
│   │   │   │   └── pdfatimesi.z
│   │   │   │   └── pdfazapfdingbats.php
│   │   │   │   └── pdfazapfdingbats.z
│   │   │   │   └── stsongstdlight.php
│   │   │   │   └── symbol.php
│   │   │   │   └── times.php
│   │   │   │   └── timesb.php
│   │   │   │   └── timesbi.php
│   │   │   │   └── timesi.php
│   │   │   │   └── uni2cid_ac15.php
│   │   │   │   └── uni2cid_ag15.php
│   │   │   │   └── uni2cid_aj16.php
│   │   │   │   └── uni2cid_ak12.php
│   │   │   │   └── zapfdingbats.php
│   │   ├── include/
│   │   │   ├── barcodes/
│   │   │   │   │   └── datamatrix.php
│   │   │   │   │   └── pdf417.php
│   │   │   │   │   └── qrcode.php
│   │   │   │   └── sRGB.icc
│   │   │   │   └── tcpdf_colors.php
│   │   │   │   └── tcpdf_filters.php
│   │   │   │   └── tcpdf_font_data.php
│   │   │   │   └── tcpdf_fonts.php
│   │   │   │   └── tcpdf_images.php
│   │   │   │   └── tcpdf_static.php
│   │   ├── tools/
│   │   │   │   └── .htaccess
│   │   │   │   └── convert_fonts_examples.txt
│   │   │   │   └── tcpdf_addfont.php
│   │   │   └── CHANGELOG.TXT
│   │   │   └── LICENSE.TXT
│   │   │   └── README.md
│   │   │   └── VERSION
│   │   │   └── composer.json
│   │   │   └── tcpdf.php
│   │   │   └── tcpdf_autoconfig.php
│   │   │   └── tcpdf_barcodes_1d.php
│   │   │   └── tcpdf_barcodes_2d.php
├── reportes/
│   │   └── exportar_excel_actividades.php
│   │   └── exportar_excel_adolescentes.php
│   │   └── exportar_excel_instituciones.php
│   │   └── generar_pdf_actividades.php
│   │   └── generar_pdf_adolescentes.php
│   │   └── reporte_adolescentes.php
│   └── .gitignore
│   └── README.md
│   └── anonimizar_datos_personales.php
│   └── conexion.php
│   └── crear_usuario.php
│   └── index.php
│   └── inicio.php
│   └── login.php
│   └── logout.php
```
