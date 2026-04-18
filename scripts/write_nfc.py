import sys
import nfc
import nfc.ndef

def write_url(tag, url):
    if not tag.ndef:
        print("❌ Tag is not NDEF compatible")
        return False

    try:
        print("🧹 Clearing tag...")
        tag.ndef.records = []

        print(f"✍️ Writing URL: {url}")
        record = nfc.ndef.UriRecord(url)
        tag.ndef.records = [record]

        print("✅ Write successful")
        return True

    except Exception as e:
        print(f"❌ Write failed: {e}")
        return False


def on_connect(tag):
    url = sys.argv[1]

    success = write_url(tag, url)

    if success:
        print("🎉 Done. Remove tag.")
    else:
        print("⚠️ Try again.")

    return False  # disconnect after operation


def main():
    if len(sys.argv) < 2:
        print("Usage: python write_nfc.py <URL>")
        sys.exit(1)

    print("📡 Waiting for NFC tag...")

    try:
        clf = nfc.ContactlessFrontend('usb')
        clf.connect(rdwr={'on-connect': on_connect})
    except Exception as e:
        print(f"❌ NFC Reader error: {e}")


if __name__ == "__main__":
    main()
