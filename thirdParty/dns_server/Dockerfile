FROM alpine:latest

# Instala o dnsmasq sem manter o cache do gerenciador de pacotes (imagem menor)
RUN apk add --no-cache dnsmasq

# Expõe a porta padrão do DNS
EXPOSE 53/udp 53/tcp

# Executa o dnsmasq em primeiro plano (-k) para o container não fechar
CMD ["dnsmasq", "-k"]