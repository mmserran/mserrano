# LAB-MSERRANO

# install node
```shell
sudo apt-get install nodejs
node -v
```
* NOTE
*  yarn requires node >= v6.11.5
*  17.10 (Artful Aardvark) was released with node v6.11.4
*  below will upgrade node to v8.x
```shell
sudo apt-get install curl
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
sudo apt-get remove nodejs && sudo apt-get install nodejs
```

# install yarn (debian)
```shell
sudo apt-get install curl
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt-get update && sudo apt-get install yarn
```

# setup alias
```shell
echo alias y=yarn >> /home/ {{YOUR USER}}/.bashrc
```

# restart shell
```shell
exec bash
```

# install dependencies
```shell
y install
```

# watch changes (unminified)
```shell
y dev
```

# build for production (minified)
```shell
y prod
```

# run JS tests
```shell
y test
```

# run JS coverage tests
```shell
y cov
```

# build info (webpack --verbose)
```shell
y ? 
```