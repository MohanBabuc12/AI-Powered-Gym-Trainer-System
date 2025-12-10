@echo off
echo Initializing Git repository...
git init

echo Adding files...
git add .

echo Committing files...
git commit -m "Initial commit of Fitness Gym Trainer"

echo Renaming branch to main...
git branch -M main

echo Adding remote repository...
git remote remove origin
git remote add origin https://github.com/MohanBabuc12/Fitness-gym-Trainer.git

echo Pushing to GitHub...
echo.
echo NOTE: You may be asked to sign in to GitHub in a browser window.
echo.
git push -u origin main

pause