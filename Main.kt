   import org.telegram.telegrambots.bots.TelegramLongPollingBot
   import org.telegram.telegrambots.meta.api.methods.send.SendMessage
   import org.telegram.telegrambots.meta.api.objects.Update
   import org.telegram.telegrambots.meta.exceptions.TelegramApiException
   import org.telegram.telegrambots.meta.TelegramBotsApi
   import org.telegram.telegrambots.ApiContextInitializer
   import org.telegram.telegrambots.meta.api.objects.Message


   class MyBot : TelegramLongPollingBot() {
       override fun getBotUsername(): String {
           return "imbot_ayhanbot"
       }
   
       override fun getBotToken(): String {
           return "123456789:AA***...."
       }
   
       override fun onUpdateReceived(update: Update) {
           if (update.hasMessage() && update.message.hasText()) {
               val messageText = update.message.text
               val chatId = update.message.chatId
   
               if (messageText == "/start") {
                   sendTextMessage(chatId, "Hello! Ayhan :) @ayhan_Dev")
               }
           }
       }
   
       private fun sendTextMessage(chatId: Long, text: String) {
           val sendMessage = SendMessage()
               .setChatId(chatId)
               .setText(text)
   
           try {
               execute(sendMessage)
           } catch (e: TelegramApiException) {
               e.printStackTrace()
           }
       }
   }
   
   fun main() {
       ApiContextInitializer.init()
       val botsApi = TelegramBotsApi()
   
       try {
           botsApi.registerBot(MyBot())
           println("Bot started!")
       } catch (e: TelegramApiException) {
           e.printStackTrace()
       }
   }
   
