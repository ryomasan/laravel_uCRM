# # ベースイメージとして PHP を使用
# FROM php:8.2-fpm

# # 必要なパッケージをインストール
# RUN apt-get update && apt-get install -y \
#     unzip \
#     git \
#     curl \
#     libzip-dev \
#     zip \
#     nodejs \
#     npm \
#     && docker-php-ext-install zip pdo pdo_mysql

# # Composer をインストール（必要に応じて）
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # 作業ディレクトリを指定
# WORKDIR /var/www

# # ホストのLaravelプロジェクトをコピー
# COPY . /var/www/

# # 環境変数を設定
# ENV COMPOSER_ALLOW_SUPERUSER=1

# # Laravelの依存関係をインストール
# RUN composer install --no-scripts --no-autoloader

# # Vue.js 用の依存関係をインストール
# # RUN npm install --prefix resources/js
# RUN npm install 

# # Vue.js のビルド
# RUN npm run build
# # RUN npm run build --prefix resources/js

# # Laravelのオートローダーを更新
# RUN composer dump-autoload

# # ポートを公開
# EXPOSE 8000

# # Laravelの開発サーバーを起動
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

FROM node:20.18-slim
# コンテナ内の作業ディレクトリを作成
WORKDIR /app
# パッケージ関連ファイルを先にコピーして依存関係をインストール
COPY package*.json ./

RUN apt update && npm install

# アプリケーション全体をコピー
COPY . .

# Viteで使用するポートを公開
EXPOSE 5173

# デフォルトのコマンド（コンテナ起動時に実行する）
CMD ["npm", "run", "dev", "--", "--host"]