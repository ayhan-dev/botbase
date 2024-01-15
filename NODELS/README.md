# Telegram bot with node.js 


## About 
To create a Telegram bot using Node.js, you can use the "node-telegram-bot-api" library. 
Here are the steps to create a simple Telegram bot:


1 **Create a telegram bot**

- Open the Telegram app and search for the "BotFather" bot.
- Start a chat with BotFather and use the /newbot command to create a new bot.
- Follow the instructions to set a name and username for your bot, and BotFather will provide you with a token.


2 **Install Node.js and npm:**

- Make sure you have Node.js and npm installed on your machine.

3 **Initialize Your Node.js Project:**

- Create a new directory for your project and run npm init to initialize a new Node.js project. Follow the prompts to set up your project.

4 **Install the node-telegram-bot-api library:** 

- Run the following command to install the node-telegram-bot-api library:

```
npm install node-telegram-bot-api

```

5 **Write Your Bot Code:**

- Create a JavaScript file (e.g., **bot.js**) and write your bot code.

```
const TelegramBot = require('node-telegram-bot-api');


const token = 'YOUR_BOT_TOKEN';
const bot = new TelegramBot(token, { polling: true });


bot.onText(/\/start/, (msg) => {
  const chatId = msg.chat.id;
  bot.sendMessage(chatId, 'Hello World');
});


```

6 **Run Your Bot:**

- Save your changes and run your bot using the following command:

```
node bot.js
```


Your bot should now be running and responding to the /start command as well as any incoming messages.