cd /d "%~dp0"

rd /s /q "../phpRecDB/assets/"
mkdir "../phpRecDB/assets"

rd /s /q "../phpRecDB/misc/"
mkdir "../phpRecDB/misc"

rd /s /q "../phpRecDB/screenshots/"
mkdir "../phpRecDB/screenshots"

rd /s /q "../phpRecDB/themes/ratmbootlegs/"

REM rd /s /q "../phpRecDB/app/common/libs/yiiframework/i18n/data/"
REM mkdir "../phpRecDB/app/common/libs/yiiframework/i18n/data"

ATTRIB +H "..\phpRecDB\app\common\libs\yiiframework\i18n\data\en_us.php"
DEL /Q "..\phpRecDB\app\common\libs\yiiframework\i18n\data\*.*"
ATTRIB -H "..\phpRecDB\app\common\libs\yiiframework\i18n\data\en_us.php"

for /D %%i in (../phpRecDB/app/common/libs/yiiframework/views/*) do rd /S/Q "../phpRecDB/app/common/libs/yiiframework/views/%%i"  

rd /s /q "../phpRecDB/app/backend/extensions/bootstrap/assets/js/ckeditor/"

copy /Y "overridefiles\dbConfig.php" "../phpRecDB/settings/"
copy /Y "overridefiles\jquery-ui.min.js" "..\phpRecDB\app\common\libs\yiiframework\web\js\source\jui\js\"