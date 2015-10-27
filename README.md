# docker 

## Usage 

### 1. run nginx proxy  

```
docker run -p 80:80 -e DOCKER_HOST -e DOCKER_CERT_PATH -e DOCKER_TLS_VERIFY -v $DOCKER_CERT_PATH:$DOCKER_CERT_PATH -d -it jwilder/nginx-proxy
```

cf.[jwilder/nginx-proxy](https://github.com/jwilder/nginx-proxy)

### 2. build your image  

```
echo 'curl -L ....... <- this is docker script ' | ./rcms_build your_local_url.com
```

than build your image as URL = your_url.com

edit /etc/host if you need    

### 3. run your docker image
 

```
./rcms_run {site_id} your_local_url.com
```

than run your image.

you can SSH to your container with password = "password"
