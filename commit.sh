#!/bin/bash

# Script untuk commit dan push otomatis
# Usage: ./commit.sh "pesan commit"

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🚀 JasaLaundry Git Helper${NC}"
echo "=================================="

# Cek apakah ada pesan commit
if [ -z "$1" ]; then
    echo -e "${RED}❌ Error: Pesan commit diperlukan${NC}"
    echo "Usage: ./commit.sh \"pesan commit\""
    exit 1
fi

COMMIT_MESSAGE="$1"

echo -e "${YELLOW}📝 Checking git status...${NC}"
git status

echo ""
echo -e "${YELLOW}📦 Adding all changes...${NC}"
git add .

echo ""
echo -e "${YELLOW}💾 Committing with message: \"$COMMIT_MESSAGE\"${NC}"
git commit -m "$COMMIT_MESSAGE"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Commit berhasil!${NC}"
    
    echo ""
    echo -e "${YELLOW}🌐 Pushing to GitHub...${NC}"
    git push origin main
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}🎉 Push berhasil! Perubahan sudah di GitHub.${NC}"
        echo ""
        echo -e "${GREEN}🔗 Repository: https://github.com/Novandrya1/jasalaundry-system${NC}"
    else
        echo -e "${RED}❌ Push gagal. Cek koneksi atau credentials.${NC}"
    fi
else
    echo -e "${RED}❌ Commit gagal. Tidak ada perubahan atau ada error.${NC}"
fi

echo ""
echo -e "${YELLOW}📊 Git log terakhir:${NC}"
git log --oneline -3