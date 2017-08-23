# LAB-MSERRANO

# install node
```shell
sudo apt-get install nodejs-legacy
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

# build info (webpack --verbose)
```shell
y ?
```