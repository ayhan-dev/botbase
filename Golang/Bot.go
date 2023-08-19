package main

import ("log" "github.com/go-telegram-bot-api/telegram-bot-api")

func main() {
    bot, err := tgbotapi.NewBotAPI("585665:AA")
    
   if err != nil {
      log.Panic(err)
    }

    bot.Debug = true
    log.Printf("Authorized on account %s", bot.Self.UserName)

    u := tgbotapi.NewUpdate(0)
    u.Timeout = 60
    updates, err := bot.GetUpdatesChan(u)

    for update := range updates {
        if update.Message == nil { 
            continue
        }

        if update.Message.Text == "/start" {
            msg := tgbotapi.NewMessage(update.Message.Chat.ID, "Hi ayhan - @Ayhan_Dev")
            _, err := bot.Send(msg)
            if err != nil {
                log.Println(err)
            }
        }
    }
}
