import random
import logging
from aiogram import Bot, Dispatcher, executor, types

bot = Bot(token = "token")
dp = Dispatcher(bot)
logging.basicConfig(level=logging.INFO)
generate_button = types.KeyboardButton('Generate')

keyboard = types.ReplyKeyboardMarkup(resize_keyboard=True).add(generate_button)
chars = 'abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
generated_passwords = 0

@dp.message_handler(commands="start")
async def start(message: types.Message):
    user_id = message.chat.id
    await bot.send_message(user_id, "Hello! I am a password generator bot.", reply_markup=keyboard)


@dp.message_handler(commands="generate")
async def generate_password(message: types.Message):   
    global generated_passwords
    user_id = message.chat.id
    generated_passwords += 1
    number = 1
    length = 28
    for _ in range(number):
        
        password = ''.join(random.choice(chars) for _ in range(length))
        await bot.send_message(user_id, f"Your password: <code>{password}</code>", parse_mode=types.ParseMode.HTML, reply_markup=keyboard)

if __name__ == "__main__":
    executor.start_polling(dp, skip_updates=True)
