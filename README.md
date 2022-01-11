# rr-et
![rr-et_logo_readme](https://user-images.githubusercontent.com/61964919/148886040-e4b31a58-529d-4ef9-a9cd-64e763251a97.png)

<h2 style="text-align: center"> 「あるある」でつながる、</h2>
<h2 style="text-align: center"> RR-ET(アルアル・イーティー)</h2>

![rr-et_service_summary_220111](https://user-images.githubusercontent.com/61964919/148910478-cccb546b-e2fd-4327-bcd5-5259222c06a2.png)


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
| ネタ関連機能 | 投稿・編集・削除・検索機能 |
| カテゴリ関連機能 | ネタに関連するカテゴリーごとに閲覧する機能 |
| ネタ いいね機能 | - |
| ネタ コメント機能 | - |
| 単体・E2Eテスト機能 | PHPUnit, Cypress |

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

### バックエンド

- PHP7.4
- Laravel 6.x
- MySQL

#### 使用した ライブラリー / フレームワーク
| 名称 | 備考 |
| --- | --- |
| PHPUnit | 単体テスト |
| laracasts / cypress | E2Eテストでのバックエンド側データ操作のため |
| guzzle | メール認証で Mailgun API を使用するため |

### フロントエンド

- JavaScript (ES6)
- jQuery

#### 使用した ライブラリー / フレームワーク 
| 名称 | 備考 |
| --- | --- |
| Bootstrap4 | - |
| FontAwesome | - |
| jScroll | 無限スクロール |

### インフラ：AWS
- Terraform を用いて環境構築を一部コード化しました。

| 名称 |  | 備考 | Terraform化 |
| --- | --- | --- | --- |
| EC2 | Web サーバー: Nginx | - | o |
| RDS | RDBMS: MySQL | - | o |
| Route 53 | DNSサービス | - | - |
| ELB (ALB) | 負荷分散機能 | - | - |
| Certificate Manager | SSL証明書 サービス | - | - |


### 開発環境
- Docker 20.10.8
- Docker-compose 1.29.2


### その他
WIP


<a id="anchor5"></a>

## ER図
![ER_diagram_220111](https://user-images.githubusercontent.com/61964919/148906463-2878a3dd-6914-45eb-8def-10ef7f29a0a6.png)

<a id="anchor6"></a>

## システム構成図

![Infrastracture_Diagram_20220111_004](https://user-images.githubusercontent.com/61964919/148925218-6b799f58-7b8d-4041-8747-29e7d2e91c4e.png)

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
- 異常系: 入力フォームは境界値分析

### テスト実施範囲

| ユーザー \ テスト 種類 | 単体 | E2E | 備考 |
| ---- | ---- | ---- | ---- |
| User | x | x | - |
| Auth | o | o | - |
| Category | o | o | - |
| Script | o | o | - |
| Like | o | o | - |
| Comment | o | o | - |
- o : 実施
- x : 未実施
- WIP : 実施中
- \- : 該当項目なし / 特になし

### デプロイ方法

- 手動デプロイ

<a id="anchor8"></a>

## こだわり・苦戦したポイント

### 


<a id="anchor9"></a>

## 今後の計画
WIP

### 追加予定機能
WIP