local telegram = require('telegram-bot-lua')
local bot = telegram('383838:AA')--token bot

bot.command('start', function(message)
    local keyboard = {
        {"Click in"}
    }
    bot.sendMessage(message.chat.id, "Hi Ayhan - @Ayhan_Dev", nil, false, nil, telegram.inlineKeyboard(keyboard))
end)

bot.on('callbackQuery', function(callback_query)
    if callback_query.data == 'click' then
        bot.answerCallbackQuery(callback_query.id, "hi :)🐈 ")
    end
end)
