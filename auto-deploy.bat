@echo off
echo =======================================
echo   Auto-Deploy Script for Dijadiin
echo =======================================

:: Ganti rexxus166 dengan username Docker Hub-mu yang asli
set DOCKER_IMAGE=rexxus166/dijadiin:latest

echo [1/4] Building Docker Image...
docker build -t %DOCKER_IMAGE% .

echo [2/4] Pushing Docker Image...
docker push %DOCKER_IMAGE%

echo [3/4] Mengganti nama image di deployment.yaml dan Menerapkan ke Server...
powershell -Command "(gc server/deployment.yaml) -replace '<username-dockerhub>/dijadiin:latest', '%DOCKER_IMAGE%' | Out-File -encoding ASCII server/deployment.yaml"
kubectl --kubeconfig=server/kubeconfig.yaml apply -f server/deployment.yaml

echo [4/4] Restarting Pod...
kubectl --kubeconfig=server/kubeconfig.yaml rollout restart deployment/dijadiin-app -n poliwindra

echo =======================================
echo Deployment selesai!
echo Buka aplikasi di: https://poliwindra.hackathon.sev-2.com
echo =======================================
pause
