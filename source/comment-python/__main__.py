from pyrogram import filters, Client
from pyrogram.types import Message
import requests
# Is wroten by Erwinex <3 :)
app = Client(name="comment",
             api_id=, # Fill it with your own one
             api_hash="" # Fill it with your own one
             )

# Get a random quote to comment
def get_random_quote():
    url = "https://api.quotable.io/random"
    try:
        response = requests.get(url)
        response.raise_for_status()  # Raise an HTTPError for bad responses

        data = response.json()
        content = data["content"]
        author = data["author"]
        return f'"{content}" - {author}'
    # It will call it self if anything went wrong
    except requests.exceptions.RequestException as e:
        print(e)
        return get_random_quote()

# This decorator will call the given function if client get any message from a channel
@app.on_message(filters.channel)
async def comment(client: Client, message: Message):
    print(message.sender_chat.title + f" ID: {message.sender_chat.id}")
    m = None
    try:
        # Get the discussion message
        m = await app.get_discussion_message(message.sender_chat.id, message.id)
        print("Fine")
        discussion = True
    except:
        print("No discussion")
        discussion = False

    with m:
        # Comment to the post by replying
        if discussion:
            quote = get_random_quote()
            await m.reply(quote)


app.run()
