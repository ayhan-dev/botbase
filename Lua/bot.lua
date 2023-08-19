local telegram = require('telegram-bot-lua')
local bot = telegram('383838:AA')
bot.command('start', function(message)
    bot.sendMessage(message.chat.id, 'hi Ayhan - @Ayhan_Dev')
end)

bot.start()
