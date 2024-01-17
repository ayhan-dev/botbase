from pyrogram import Client, filters, enums
from apscheduler.schedulers.asyncio import AsyncIOScheduler
import datetime
from datetime import datetime
import pytz
from pyrogram.types import Message, ReplyKeyboardMarkup
# Is wroten by Erwinex <3 :)
app = Client(name="Clock",
             api_id=int(),# Fill it with your own one
             api_hash="",# Fill it with your own one

             )
country = "" # Your country name in pytz
# Get client data and do some first time declereations
with app:
    me = app.get_me()
    print(me.first_name)
    is_on = False
    scheduler = None
print("Is running")

# Check if the gotten message is sended by the client -> True else it gives a False value
def func_is_me(_, client: Client, message: Message):
    if message.from_user.id == me.id:
        return True
    else:
        return False

# Creating a custom filter with the mentioned function
is_me = filters.create(func_is_me)

# This decorator will run every time the client send a message and the content is /ping
@app.on_message(filters.command("ping") & is_me)
async def on_ping(client: Client, message: Message):
    await message.reply_chat_action(enums.ChatAction.PLAYING)

    await message.reply_text("All things configured.")

# This decorator will run every time the client send a message and the content is /clockon
@app.on_message(filters.command("clockon") & is_me)
async def on_start(client:Client, message:Message):
    global is_on
    # Check if the function is already runnig to pervent over writing in profile
    if not is_on:
        global me
        me = await client.get_me()
        await message.reply_chat_action(enums.ChatAction.PLAYING)
        await message.reply_text("Hi. Adolf Hitler was an Austrian-born German politician who was the dictator of Germany from 1933 until his suicide in 1945. He rose to power as the leader of the Nazi Party, becoming the chancellor in 1933 and then taking the title of Führer und Reichskanzler in 1934 by the way now the clock is on.")
        dt_us_central = datetime.now(pytz.timezone(country))
        # Change the client name add the time to the name
        await app.update_profile(me.first_name + " ({})".format(dt_us_central.strftime("%H:%M")))
        # This funtion will schule to run every second
        async def clock_on_name():
            dt_us_central = datetime.now(pytz.timezone(country))
            # Check if the time change a minute
            if dt_us_central.strftime("%S") == "00":
                dt_us_central = datetime.now(pytz.timezone(country))
                now = dt_us_central.strftime("%H:%M")
                # Update the client profile
                await app.update_profile(me.first_name + f" ({now})")
        
        global scheduler
        # Make a async scheduler object and add the upper function to it job to run every second
        scheduler = AsyncIOScheduler()
        scheduler.add_job(clock_on_name, "interval", seconds=1, id="1")

        scheduler.start()
        is_on = True # Make the variable value True to prevent over writing in profile
    else:
        await message.reply_chat_action(enums.ChatAction.PLAYING) # this line is just for fun :) and not nessecry
        await message.reply_text("The clock is already on.")

# This decorator will run every time the client send a message and the content is /clockoff
@app.on_message(filters.command("clockoff") & is_me)
async def on_stop(client: Client, message: Message):
    await message.reply_text("Now the clock is off.")
    # Change the name to the name before sending /clockon
    await app.update_profile(me.first_name)
    global scheduler , is_on
    is_on = False
    # Remove the scheduled job
    scheduler.remove_job("1")


app.run()
