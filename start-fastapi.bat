@echo off
echo ========================================
echo   FASTAPI SERVER - Mesin Inferensi
echo ========================================
echo.
echo Starting FastAPI development server...
echo URL: http://127.0.0.1:8001
echo Docs: http://127.0.0.1:8001/docs
echo.
echo Press CTRL+C to stop the server
echo ========================================
echo.

cd Mesin_Inferensi
uvicorn main:app --reload --port 8001

pause
