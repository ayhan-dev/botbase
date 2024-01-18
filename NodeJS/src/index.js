const TelegramBot   = require('node-telegram-bot-api');
const request       = require('request');

const config = require('dotenv').config();


const token         = process.env.API_TOKEN;
const bot           = new TelegramBot(token,{polling:true});
 
function getUserData(chat) {
  let user = storage[chat]
  if (!user) {
    user = {
      waitingForCity:    false,
      waitingForWeather: false,
      waitingForTime:    false,
    }
    storage[chat] = user
  }
  return user
}

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




bot.on('callback_query', async (callbackQuery) => {
  const chatId = callbackQuery.message.chat.id
  const data   = callbackQuery.data

  switch (data) {
    case 'ayhan':
      const userDataWeather = getUserData(chatId)
      userDataWeather.waitingForCity    = true
      userDataWeather.waitingForWeather = true
      bot.sendMessage(chatId, 'my ayhan @Ayhan_Dev')
      break

  }
})


console.log('running app')