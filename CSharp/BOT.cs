
using System;
using Telegram.Bot;
using Telegram.Bot.Args;
namespace SimpleBot{ 
  
    class Program{
        static ITelegramBotClient botClient;
        static void Main(){
            botClient = new TelegramBotClient("2528:AA");
            botClient.OnMessage += Bot_OnMessage;
            botClient.StartReceiving();
            Console.WriteLin("n");
            Console.ReadKey();
            botClient.StopReceiving();
        }

        private static async void Bot_OnMessage(object sender, MessageEventArgs e) {
            if (e.Message.Text != null && e.Message.Text.ToLower() == "/start") {
                await botClient.SendTextMessageAsync(
                    chatId: e.Message.Chat,
                    text: "hi ayhan - @Ayhan_Dev");
            }
        }
    }
}

