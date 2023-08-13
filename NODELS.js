const TelegramBot   = require('node-telegram-bot-api');
const request       = require('request');

const token         = '6317234969:AA....';
const bot           = new TelegramBot(token,{polling:true});

bot.onText(/\/start/, (msg) => {
  bot.sendMessage(msg.chat.id, "hi"); 
});
