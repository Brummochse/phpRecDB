cd /d "%~dp0"

rd /s /q "../phpRecDB/assets/"
mkdir "../phpRecDB/assets"

rd /s /q "../phpRecDB/screenshots/"
mkdir "../phpRecDB/screenshots"

rd /s /q "../phpRecDB/themes/ratmbootlegs/"

rd /s /q "../phpRecDB/misc/runtime/cache/"

rd /s /q "../phpRecDB/app/backend/extensions/yiibooster-4-0-1/assets/ckeditor/"
rd /s /q "../phpRecDB/app/backend/extensions/yiibooster-4-0-1/assets/bootstrap-datepicker/"
rd /s /q "../phpRecDB/app/backend/extensions/yiibooster-4-0-1/assets/redactor/"
rd /s /q "../phpRecDB/app/backend/extensions/yiibooster-4-0-1/assets/bootstrap-datetimepicker/"
rd /s /q "../phpRecDB/app/backend/extensions/yiibooster-4-0-1/assets/bootstrap3-wysihtml5/"
rd /s /q "../phpRecDB/app/backend/extensions/yiibooster-4-0-1/assets/highcharts/"

REM rd /s /q "../phpRecDB/app/common/libs/yiiframework/i18n/data/"
REM mkdir "../phpRecDB/app/common/libs/yiiframework/i18n/data"

ATTRIB +H "..\phpRecDB\app\common\libs\yiiframework\i18n\data\en_us.php"
DEL /Q "..\phpRecDB\app\common\libs\yiiframework\i18n\data\*.*"
ATTRIB -H "..\phpRecDB\app\common\libs\yiiframework\i18n\data\en_us.php"

for /D %%i in (../phpRecDB/app/common/libs/yiiframework/views/*) do rd /S/Q "../phpRecDB/app/common/libs/yiiframework/views/%%i"  

copy /Y "overridefiles\dbConfig.php" "../phpRecDB/settings/"
copy /Y "overridefiles\index.php" "../"
REM copy /Y "overridefiles\jquery-ui.min.js" "..\phpRecDB\app\common\libs\yiiframework\web\js\source\jui\js\"

REM in phpRecDB.php das debug auskommentieren