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

# install dependencies
```shell
yarn install
```