cd /d "%~dp0"

rd /s /q "../phpRecDB/assets/"
mkdir "../phpRecDB/assets"

rd /s /q "../phpRecDB/screenshots/"
mkdir "../phpRecDB/screenshots"

rd /s /q "../phpRecDB/themes/ratmbootlegs/"

rd /s /q "../phpRecDB/misc/runtime/cache/"

rd /s /q "../phpRecDB/app/backend/extensions/yiibooster107/assets/js/locales/"

rd /s /q "../phpRecDB/app/backend/extensions/yiibooster107/assets/js/ckeditor/"

REM rd /s /q "../phpRecDB/app/common/libs/yii-1.1.15/i18n/data/"
REM mkdir "../phpRecDB/app/common/libs/yii-1.1.15/i18n/data"

ATTRIB +H "..\phpRecDB\app\common\libs\yii-1.1.15\i18n\data\en_us.php"
DEL /Q "..\phpRecDB\app\common\libs\yii-1.1.15\i18n\data\*.*"
ATTRIB -H "..\phpRecDB\app\common\libs\yii-1.1.15\i18n\data\en_us.php"

for /D %%i in (../phpRecDB/app/common/libs/yii-1.1.15/views/*) do rd /S/Q "../phpRecDB/app/common/libs/yii-1.1.15/views/%%i"  

rd /s /q "../phpRecDB/app/backend/extensions/yiibooster107/assets/js/ckeditor/"

copy /Y "overridefiles\dbConfig.php" "../phpRecDB/settings/"
copy /Y "overridefiles\index.php" "../"
copy /Y "overridefiles\jquery-ui.min.js" "..\phpRecDB\app\common\libs\yii-1.1.15\web\js\source\jui\js\"