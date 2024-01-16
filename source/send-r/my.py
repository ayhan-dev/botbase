
from pyrogram import Client, filters
from pyrogram import enums
from apscheduler.schedulers.asyncio import AsyncIOScheduler 
from apscheduler.schedulers.asyncio import*
from pyrogram.enums import ChatType
import datetime

api_id = 23136380
api_hash = ""
admin = 1570497473

start = datetime.datetime.now()
app = Client("caesar",api_id,api_hash)
scheduler = AsyncIOScheduler({'apscheduler.job_defaults.max_instances':2})
async def send():
    global text_set
    await app.send_message(admin,  "send")
    async for chat in app.get_dialogs():
        if chat.chat.type in (ChatType.GROUP, ChatType.SUPERGROUP):
            try:
                await asyncio.sleep(4)
                await app.send_message(chat.chat.id, text_set)
            except:
                pass
with app:
  try:
    app.join_chat("@ayhan_GY")
  except:
    pass
@app.on_message(filters.text & filters.user(admin))
async def mes_handler(client, message):
    global text_set , texttime
    chatid = message.chat.id
    text = message.text
    if text == "ping":
        await message.reply_text('bot-ON:)')
    elif text == "send on":
        await message.reply_text('BOT-ON')
        scheduler.add_job(send, "interval", seconds=int(texttime))
    elif text == "send off":
        await message.reply_text('BOT OFF')
        scheduler.remove_all_jobs()
    elif text == "settext":
        text_set = message.reply_to_message.text
        await message.reply_text("SET. TXT")
    elif text.startswith("settime"):
        texttime = text.replace("settime", "")
        await message.reply_text('SET. Time')
            
scheduler.start()
app.run()
