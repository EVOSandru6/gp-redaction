# README

## 0. Prepare Packages

```
sudo apt-get update && apt-get upgrade -y;
sudo apt install -y curl git;
sudo apt-get install -y build-essential software-properties-common;
```

## 1. Install Docker

```
sudo apt-get remove -y docker docker-engine docker.io containerd runc;
```

```
sudo apt-get update;
```

```
sudo apt-get install -y \
 apt-transport-https \
 ca-certificates \
 curl \
 gnupg-agent \
 software-properties-common;
```

```
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -;
```

```
sudo apt-key fingerprint 0EBFCD88;
```

```
sudo add-apt-repository \
 "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
 $(lsb_release -cs) \
 stable";
```

``` 
sudo apt-get update;
sudo apt-get install -y docker-ce docker-ce-cli containerd.io;
```

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.25.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose;
```

```
sudo chmod +x /usr/local/bin/docker-compose;
```

```
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose;
```

Add rules for user id docker group

```
sudo groupadd docker;
sudo usermod -aG docker $USER;
sudo newgrp docker;
sudo reboot;
```


## 2. Start make script 
```
make restart
```