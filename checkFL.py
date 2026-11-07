import argparse
import re
import sys
from urllib.parse import parse_qs, urlparse

from yt_dlp import YoutubeDL
from yt_dlp.utils import DownloadError


DEFAULT_VIDEO_ID = "5qYZC56dneU"
VIDEO_ID_PATTERN = re.compile(r"^[A-Za-z0-9_-]{11}$")


def normalize_video_url(value):
    value = value.strip()
    if VIDEO_ID_PATTERN.fullmatch(value):
        return f"https://www.youtube.com/watch?v={value}"

    parsed = urlparse(value)
    host = (parsed.hostname or "").lower()
    if host == "youtu.be":
        video_id = parsed.path.strip("/").split("/")[0]
        if VIDEO_ID_PATTERN.fullmatch(video_id):
            return f"https://www.youtube.com/watch?v={video_id}"
    elif host == "youtube.com" or host.endswith(".youtube.com"):
        video_id = parse_qs(parsed.query).get("v", [None])[0]
        if parsed.path == "/watch" and VIDEO_ID_PATTERN.fullmatch(video_id or ""):
            return f"https://www.youtube.com/watch?v={video_id}"
        if parsed.path.startswith(("/shorts/", "/embed/", "/live/")):
            return value

    raise ValueError("Enter a YouTube video URL or an 11-character video ID.")


def get_video_info(video_url):
    options = {
        "quiet": True,
        "no_warnings": True,
        "noplaylist": True,
        "skip_download": True,
    }

    with YoutubeDL(options) as youtube:
        return youtube.extract_info(video_url, download=False)


def main():
    parser = argparse.ArgumentParser(description="Get public view count for a YouTube video.")
    parser.add_argument("video", nargs="?", default=DEFAULT_VIDEO_ID, help="YouTube URL or video ID")
    args = parser.parse_args()

    try:
        video_url = normalize_video_url(args.video)
        info = get_video_info(video_url)
    except (DownloadError, ValueError) as error:
        print(f"Error: {error}", file=sys.stderr)
        return 1
    except Exception as error:
        print(f"Error retrieving YouTube video: {error}", file=sys.stderr)
        return 1

    views = info.get("view_count")
    if views is None:
        print(f"Title: {info.get('title', 'Unknown')}")
        print("Views: unavailable")
        return 2

    print(f"Views: {views:,}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
