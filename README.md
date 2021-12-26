# rr-et
WIP
![logo_with_margin](https://user-images.githubusercontent.com/61964919/130588238-21854f7a-0496-4b89-b59a-94c7b2d6ab93.png)

<h2 style="text-align: center"> 「あるある」を投稿する、RR-ET(アルアル・イーティー)</h2>

![service_summary_image_210906](https://user-images.githubusercontent.com/61964919/132218158-f9f9ce9d-3fb8-4888-972b-1718bbdb6fee.png)

Laravel6 PHP MySQL Bootstrap4
AWS(EC2, RDS Route53, ALB) Docker

## 目次
- [プロジェクトの概要説明](#anchor1)
- [実装機能 一覧](#anchor2)
- [サービス GIFアニメ（デモ）](#anchor3)
- [使用言語、環境、テクノロジー](#anchor4)
- [ER図](#anchor5)
- [システム構成図](#anchor6)
- [使い方](#anchor7)
- [こだわり・苦戦したポイント](#anchor8)
- [今後の予定](#anchor9)


<a id="anchor1"></a>

## プロジェクトの概要説明
日常のあるあるを投稿をみることで、ちょっとした笑いや業界知識に対して「へ〜」という気持ちになれるアプリです。

あるあるネタのことを以下から「ネタ」と表記します。

<a id="anchor2"></a>

## 実装機能 一覧

### 機能概要
|  機能  |  概要 | 
| ---- | ---- |
| ネタ関連機能 | 投稿・編集・削除機能 |
| カテゴリ関連機能 | ネタに関連するカテゴリーを登録する機能 |
| - | - |

### アクション実行権限 一覧
- ログインユーザー・管理者に関して、特記なき場合はログインをしているユーザー自身が行なった投稿に対してのみ実行できることとします。

|記号|意味|
| ---- | ---- |
| o | 実行可能 |
| - | 該当アクションなし|
| x | 実行不可 | 
#### ネタ関連(ScriptTable)
| ユーザー \ アクション | index | show | create | store | edit | update | destroy |
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | ---- |
| 未ログイン | x | - | x | x | x | x | x |
| ログインユーザー | o | - | o | o | o | o | o |
| 管理者 | o | - | o | o | o | o | (1) |

- (1) ログインユーザー自身と管理者が実行可能

#### カテゴリー関連(CategoryTable)
| ユーザー \ アクション | index | show | create | store | edit | update | destroy |
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | ---- |
| 未ログイン | x | x | x | x | x | x | x |
| ログインユーザー | o | o | x | x | x | x | x |
| 管理者 | o | o | o | o | o | o | o |


<a id="anchor3"></a>

## サービスのスクリーンショット画像 or デモGIF 動画
WIP

- レスポンシブ対応 (スマホ・タブレット・PC)
- 写真(Home画面)
![pages_home_210906](https://user-images.githubusercontent.com/61964919/132216450-133f326d-6193-4490-81d3-b773563d5c54.png)

### 製品 性能別ランキング

- Home -> ゲストログイン -> 製品一覧(レビュー評価でソート) -> 検索 -> 該当製品をレビュー評価でソート) -> 製品詳細

![sort_search_feature_210927](https://user-images.githubusercontent.com/61964919/134905784-1f98d194-61f5-4502-be7d-ee5573a73719.gif)

### 製品比較機能(Bookmark)

- 製品詳細(Bookmark登録) -> 別製品 Bookmark登録 -> 登録数バリデーション(2つまで) -> 登録を1つ解除 -> 製品登録

![bookmark_feature_210927](https://user-images.githubusercontent.com/61964919/134905650-1e108401-f83b-4d71-80a5-cca1a6b3bfe9.gif)
### 口コミ投稿 / いいね 機能
- 製品詳細ページ(画像込みで投稿) -> 投稿したレビューにいいね(Ajax)
![post_feature_210927](https://user-images.githubusercontent.com/61964919/134905672-c706a481-49db-4316-a0a2-3732bd2973c3.gif)

- ユーザープロフィール画面から投稿 (製品選択:Ajax)
![post_feature_user_210927](https://user-images.githubusercontent.com/61964919/134905680-aba5a609-af92-47aa-bb6d-c0af6e0f3022.gif)


<a id="anchor4"></a>

## 使用言語、環境、テクノロジー
WIP

### 意識したポイント

- 「リーダブルコード」を読んだ知見を生かし、「意図がわかりやすい変数の命名」を意識してコーディングしました。
- パフォーマンスを意識して、N+1問題が発生しないよう考慮しながらコーディングしました。

### バックエンド

- PHP7.4
- Laravel 6.x
- MySQL

#### 使用した composer
| 名称 | 備考 |
| --- | --- |

### フロントエンド

- Bootstrap 4
- Font-Awesome
- jQuery
- JavaScript (ES6)

### インフラ：AWS
| 名称 |  | 備考 |
| --- | --- | --- |
| EC2 | App サーバー: Unicorn | - |
|  | Web サーバー: Nginx | - |
| RDS | RDBMS: MySQL | - |
| Route 53 | DNSサービス | - |
| S3 | ストレージ機能 | - |
| ELB (ALB) | 負荷分散機能 | - |
| Certificate Manager | SSL証明書 サービス | - |


### 開発環境
- Docker 20.10.8
- Docker-compose 1.29.2


### その他
WIP


<a id="anchor5"></a>

## ER図
WIP

![ER_diagram_210927](https://user-images.githubusercontent.com/61964919/134922029-41632c1a-3e61-495c-897b-40981918761f.png)

<a id="anchor6"></a>

## システム構成図

WIP
![Infrastracture_Diagram_20210906](https://user-images.githubusercontent.com/61964919/132186932-927de9f5-a5f3-48fb-9fc7-d59ab98fad67.png)

<a id="anchor7"></a>

## 使い方

### インストール・開発環境下での実行方法

#### 共通
```
$ git clone https://github.com/Misha434/rr-et.git
$ cd smar-003
```

#### Docker 環境
```
$ docker-compose up -d
```

### テスト方法

- 正常系
- 異常系: 入力フォームは異常値・境界値分析を行っています

### デプロイ方法

- Capistranoで自動デプロイ

<a id="anchor8"></a>

## こだわり・苦戦したポイント

### 環境構築
- Asset Pipeline 未使用にした環境構築に苦労しました。「Precompile が遅い」という記事を見て対応したのですが、環境を統一せず環境構築が完了する前に同時に作業を進めたために、手戻りが多数発生しました。

### レビュー投稿機能

- 自己プロフィール画面から口コミ投稿する際に、ブランドから製品を絞り込む Ajax処理を実装しました。
- Ruby側の変数と、JavaScript側の変数の受渡しの方法がわからず長期間手詰まりを起こしました。jbuilderを利用することで解決しました。
### 製品口コミ 平均値表示機能

- レビュー数:1 の状態から、レビュー全削除をした際にレビュー平均値が nil になってしまうエラーが起きて手詰まりになったことがありました。その際に nilガード・デバックのことを学べました。

- 評価の星表示部分は自作しています。


<a id="anchor9"></a>

## 今後の計画
WIP

### 追加予定機能
WIP