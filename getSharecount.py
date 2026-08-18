import requests
import time
import re
import json
from bs4 import BeautifulSoup
from urllib.parse import urlparse, parse_qs

# =========================
# HEADERS
# =========================

HEADERS = {
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "User-Agent": (
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
        "AppleWebKit/537.36 (KHTML, like Gecko) "
        "Chrome/134.0.0.0 Safari/537.36"
    ),
    "Origin": "https://www.facebook.com",
    "Sec-Fetch-Site": "same-origin",
}


# =========================
# EXTRACT POST ID
# =========================

def extract_facebook_id(input_value):

    input_value = input_value.strip()

    # Nếu nhập trực tiếp ID
    if "/" not in input_value:
        return input_value

    parsed = urlparse(input_value)

    # posts
    match = re.search(r"/posts/(\d+)", parsed.path)
    if match:
        return match.group(1)

    # reels
    match = re.search(r"/reel/(\d+)", parsed.path)
    if match:
        return match.group(1)

    # watch?v=
    query = parse_qs(parsed.query)

    if "v" in query:
        return query["v"][0]

    # story.php
    if "story_fbid" in query:
        return query["story_fbid"][0]

    return input_value


# =========================
# GET SHARE COUNT
# =========================

def get_share_count(uid, max_retries=5):

    url = f"https://www.facebook.com/{uid}/?locale=en_US"

    for attempt in range(max_retries):

        print(f"\n🔄 Thử lần {attempt + 1}/{max_retries}")

        try:

            headers = HEADERS.copy()
            headers["Referer"] = url

            response = requests.get(
                url,
                headers=headers,
                timeout=10
            )

            response.raise_for_status()

            soup = BeautifulSoup(response.text, "html.parser")

            scripts = soup.find_all("script")

            for script in scripts:

                script_text = script.string or script.text

                if '"share_count":{"count"' not in script_text:
                    continue

                match = re.search(
                    r'"share_count":\{"count":\d+,"is_empty":(?:true|false)\}',
                    script_text
                )

                if not match:
                    continue

                json_string = "{" + match.group(0) + "}"

                data = json.loads(json_string)

                share_count = data["share_count"]["count"]

                return share_count

            print("⚠️ Không tìm thấy share count")

        except Exception as e:
            print(f"❌ Lỗi: {str(e)}")

        time.sleep(2)

    return 0


# =========================
# MAIN
# =========================

print("=" * 50)
print("🔥 FACEBOOK SHARE COUNT CHECKER")
print("=" * 50)

user_input = input("\n📥 Nhập link hoặc post id Facebook: ")

uid = extract_facebook_id(user_input)

print(f"\n✅ ID nhận diện: {uid}")

print("\n⏳ Đang lấy share count...")

share_count = get_share_count(uid)

print("\n" + "=" * 50)
print(f"📊 SHARE COUNT : {share_count}")
print("=" * 50)
