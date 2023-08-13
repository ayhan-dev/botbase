const TelegramBot   = require('node-telegram-bot-api');
const request       = require('request');

const token         = '6317234969:AA....';
const bot           = new TelegramBot(token,{polling:true});

bot.onText(/\/start/, (msg) => {
  const chatId = msg.chat.id
  bot.sendMessage(chatId,
    'Hi ayhan - my bot test',{
      reply_markup: {
        inline_keyboard: [ 
          [{text: 'ayhan', url:'https://ayhan-dev.dev'}],
          [{ text: 'Button', callback_data: 'ayhan' }],
        ],
      },
    }
  )
})

