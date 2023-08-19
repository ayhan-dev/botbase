
from pyrogram import Client, filters

app = Client("64646:")

@app.on_message(filters.command("start"))
def start(client, message):
    message.reply_text("hi ayhan - @ayhan_Dev")

app.run()
