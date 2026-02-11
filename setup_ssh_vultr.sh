#!/bin/bash

# Setup SSH keys for Vultr deployment
set -e

echo "================================================"
echo "Setting up SSH keys for Vultr"
echo "================================================"

# Check for VULTR_API_KEY
if [ -z "$VULTR_API_KEY" ]; then
    if [ -f .env ]; then
        export $(grep -v '^#' .env | xargs)
    fi
    
    if [ -z "$VULTR_API_KEY" ]; then
        echo "❌ VULTR_API_KEY not found in .env"
        echo ""
        echo "Please add your Vultr API key to .env:"
        echo "  VULTR_API_KEY=your_api_key_here"
        echo ""
        echo "Get your API key from: https://my.vultr.com/settings/#settingsapi"
        exit 1
    fi
fi

# Generate SSH key if it doesn't exist
if [ ! -f ~/.ssh/wordpress_vultr ]; then
    echo "Generating SSH key pair..."
    ssh-keygen -t rsa -b 4096 -f ~/.ssh/wordpress_vultr -N "" -C "wordpress-vultr-deploy"
    echo "✓ SSH key generated at ~/.ssh/wordpress_vultr"
else
    echo "✓ SSH key already exists at ~/.ssh/wordpress_vultr"
fi

# Read public key
PUB_KEY=$(cat ~/.ssh/wordpress_vultr.pub)

# Upload to Vultr
echo "Uploading SSH key to Vultr..."
RESPONSE=$(curl -s -X POST "https://api.vultr.com/v2/ssh-keys" \
    -H "Authorization: Bearer $VULTR_API_KEY" \
    -H "Content-Type: application/json" \
    -d "{
        \"name\": \"wordpress-vultr-deploy\",
        \"ssh_key\": \"$PUB_KEY\"
    }")

# Extract SSH key ID
SSH_KEY_ID=$(echo $RESPONSE | python3 -c "import sys, json; data=json.load(sys.stdin); print(data.get('ssh_key', {}).get('id', ''))" 2>/dev/null || echo "")

if [ -z "$SSH_KEY_ID" ]; then
    # Try to get existing key
    echo "Key might already exist, fetching existing keys..."
    RESPONSE=$(curl -s -X GET "https://api.vultr.com/v2/ssh-keys" \
        -H "Authorization: Bearer $VULTR_API_KEY")
    
    SSH_KEY_ID=$(echo $RESPONSE | python3 -c "
import sys, json
data = json.load(sys.stdin)
for key in data.get('ssh_keys', []):
    if 'wordpress-vultr-deploy' in key.get('name', ''):
        print(key['id'])
        break
" 2>/dev/null || echo "")
fi

if [ -z "$SSH_KEY_ID" ]; then
    echo "❌ Failed to upload or find SSH key"
    exit 1
fi

# Save SSH key ID
echo "$SSH_KEY_ID" > .ssh_key_id_vultr

echo "================================================"
echo "✅ SSH Setup Complete!"
echo "================================================"
echo "SSH Key ID: $SSH_KEY_ID"
echo "Private Key: ~/.ssh/wordpress_vultr"
echo "Public Key: ~/.ssh/wordpress_vultr.pub"
echo ""
echo "Next step: Run python3 create_vultr_instance.py"
