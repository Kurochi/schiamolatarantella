@echo off

:: BatchGotAdmin
:-------------------------------------
echo Checking for administrator permissions.
    IF "%PROCESSOR_ARCHITECTURE%" EQU "amd64" (
>nul 2>&1 "%SYSTEMROOT%\SysWOW64\cacls.exe" "%SYSTEMROOT%\SysWOW64\config\system"
) ELSE (
>nul 2>&1 "%SYSTEMROOT%\system32\cacls.exe" "%SYSTEMROOT%\system32\config\system"
)

if '%errorlevel%' NEQ '0' (
    echo Not an administrator! Requesting administrative privileges...
    goto UACPrompt
) else ( goto gotAdmin )

:UACPrompt
    echo Set UAC = CreateObject^("Shell.Application"^) > "%temp%\getadmin.vbs"
    set params = %*:"=""
    echo UAC.ShellExecute "cmd.exe", "/c ""%~s0"" %params%", "", "runas", 1 >> "%temp%\getadmin.vbs"

    "%temp%\getadmin.vbs"
    del "%temp%\getadmin.vbs"
    exit /B

:gotAdmin
    echo You are an administrator!
    pushd "%CD%"
    CD /D "%~dp0"
:--------------------------------------  

:1
echo.
echo Scegli un'azione da compiere:
echo 0. status
echo 1. up
echo 2. reload
echo 3. halt
echo 4. halt -f
echo 5. ssh
echo 6. provision
echo 7. destroy
echo 8. CHIUDI SCRIPT

set /P chosenAction="":

IF "%chosenAction%"=="0" vagrant status
IF "%chosenAction%"=="1" vagrant up
IF "%chosenAction%"=="2" vagrant reload
IF "%chosenAction%"=="3" vagrant halt
IF "%chosenAction%"=="4" vagrant halt -f
IF "%chosenAction%"=="5" vagrant ssh
IF "%chosenAction%"=="6" vagrant provision
IF "%chosenAction%"=="7" vagrant destroy
IF "%chosenAction%"=="8" exit

echo Scegli un'altra azione.
echo.
goto 1