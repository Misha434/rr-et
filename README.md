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
- [実行権限一覧](#anchor9)
- [今後の予定](#anchor10)


<a id="anchor1"></a>

## プロジェクトの概要説明
「あるある」を通して、日常・ネット上でのコミュニケーションのきっかけを提供するSNSサービスです。

あるあるネタのことを以下から「ネタ」と表記します。

<a id="anchor2"></a>

## 実装機能 一覧

### 機能概要
|  機能  |  概要 | 
| ---- | ---- |
| ネタ関連機能 | 投稿・編集・削除・検索機能 |
| ネタソート機能 | いいね・新規投稿順にソート |
| ネタ いいね機能 | いいねしたネタをユーザー詳細ページで閲覧可 |
| ネタ コメント機能 | 投稿ネタに関してコメント投稿・削除 |
| ネタ 下書き機能 | - |
| カテゴリー関連機能 | ネタに関連するカテゴリーごとに閲覧する機能 |
| カテゴリー提案機能 | カテゴリー一覧にない項目を提案 |
| 認証機能 | ログイン・ログアウト・新規登録・登録内容変更 |
| ゲストログイン機能 | - |
| 単体・E2Eテスト機能 | PHPUnit, Cypress |

<a id="anchor3"></a>

## サービスのスクリーンショット画像 or デモGIF 動画

### 投稿一覧
- 無限スクロール・いいね・コメント・検索・ソート機能
![scripts_index_220113](https://user-images.githubusercontent.com/61964919/149282263-73255654-7beb-46d3-a2fa-e20f67aff071.gif)

### ネタ投稿・投稿下書き機能
![draft_220113](https://user-images.githubusercontent.com/61964919/149282519-bd076fe6-b70f-49ee-925d-3288062e9fc9.gif)

### カテゴリー提案機能
- 関連するカテゴリーがないときに、提案する機能
![カテゴリー提案_1](https://user-images.githubusercontent.com/61964919/149282844-e3ebd950-81dc-4595-a41d-9e4904ada28a.png)

- 提案投稿画面
![カテゴリー提案_2](https://user-images.githubusercontent.com/61964919/149282856-6b074350-7a9d-481a-afdd-d9bbbc064203.png)

- 管理者のみ表示できる一覧ページ。採用ボタンですぐカテゴリー追加ができます。
![カテゴリー提案_3](https://user-images.githubusercontent.com/61964919/149282860-b9533917-7355-4153-8363-7d8c2782e021.png)

![カテゴリー提案_4](https://user-images.githubusercontent.com/61964919/149282862-66b4fe92-4a14-441c-850c-44aa3ee421a6.png)


<a id="anchor4"></a>

## 使用言語、環境、テクノロジー

### バックエンド

- PHP 7.4
- Laravel 6.20.43
- MySQL 5.7

#### バックエンド側 使用ライブラリー/フレームワーク
| 名称 | 備考 |
| --- | --- |
| guzzle | メール認証で Mailgun API を使用するため |
| column-sortable | ソート機能 |
| PHPUnit | 単体テスト |
| laracasts / cypress | E2Eテストでのバックエンド側データ操作のため |

### フロントエンド

- JavaScript (ES6)
- jQuery

#### フロントエンド側 使用ライブラリー / フレームワーク 
| 名称 | 備考 |
| --- | --- |
| Bootstrap4 | - |
| FontAwesome | アイコン |
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

<a id="anchor5"></a>

## ER図
![ER_diagram_220111](https://user-images.githubusercontent.com/61964919/149283399-3c623cb3-7967-4b3e-a717-234d73cfcddb.png)

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

### デプロイ方法

- 手動デプロイ

<a id="anchor8"></a>

## 工夫したポイント
### ネタ編集機能
投稿後にネタ内容を編集する場合は、その投稿のいいね全取消・投稿済コメントには「このコメントはネタ内容変更前のコメントです」と告知するようにしました。

### ユーザー権限
ユーザー権限に関するカラム(role)の番号の割当てを、権限設定の追加・変更しやすいように設計しました。

### DB インデックス設計
各テーブルの 'id', と固有値 (ex: User: id, email)にはUnique制約、更新頻度が少なく検索頻度が多いカラムにはindexを付与しました。

### いいねの二重クリック防止
いいね機能で二重送信を防ぐために、フロント側・バックエンド側で対策しました。フロント側では二重クリックを無効化する仕様とし、バックエンド側ではregenerateTokenをかけることでエラーが発生するように実装しました。

### N+1問題への対策
- パフォーマンスを意識して N + 1問題を発生させないようにコーディングを進めました。

### ゲストログイン
- ゲストログイン時は、プロフィール編集画面へのアクセス・updateアクションを不可となるようにしました。

### コーディングで意識したこと
- 変数などは意図が分かる命名を心がけ、アクションなどを実装する際には、実行内容のまとまりごとに空白を空けて段落分けしました。

<a id="anchor9"></a>
### 実行権限 一覧
- ログインユーザー・管理者に関して、特記なき場合はログインをしているユーザー自身が行なった投稿に対してのみ実行できることとします。

|記号|意味|
| ---- | ---- |
| o | 実行可能 |
| - | 該当アクションなし|
| x | 実行不可 | 
#### ホーム画面(HomeController)
| ユーザー \ アクション | Home |
| ---- | ---- |
| 未ログイン | o |
| ログインユーザー | o |
| 管理者 | o |

#### ネタ関連(ScriptController)
| ユーザー \ アクション | index | show | create | store | edit | update | destroy |
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | ---- |
| 未ログイン | x | - | x | x | x | x | x |
| ログインユーザー | o | - | o | o | o | o | o |
| 管理者 | o | - | o | o | x | o | (1) |

- (1) 全ユーザーの投稿に対して実行可能

#### カテゴリー関連(CategoryController)
| ユーザー \ アクション | index | show | create | store | edit | update | destroy |
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | ---- |
| 未ログイン | x | x | x | x | x | x | x |
| ログインユーザー | o | o | x | x | x | x | x |
| 管理者 | o | o | o | o | o | o | o |

#### いいね関連(LikeController)
| ユーザー \ アクション | store | destroy |
| ---- | ---- | ---- |
| 未ログイン | x | x |
| ログインユーザー | o | o |
| 管理者 | o | o |

#### コメント関連(CommentController)
| ユーザー \ アクション | store | destroy |
| ---- | ---- | ---- |
| 未ログイン | x | x |
| ログインユーザー | o | o |
| 管理者 | o | (1) |
- (1) ログインユーザー自身と管理者が実行可能

#### 提案関連(ProposalController)
| ユーザー \ アクション | index | create | store | destroy | aprove |
| ---- | ---- | ---- | ---- | ---- | ---- |
| 未ログイン | x | x | x | x | x |
| ログインユーザー | o | o | x | x | x | x | x |
| 管理者 | o | o | o | o | o | o | o |



<a id="anchor10"></a>

## 今後の課題
- インフラの完全Terraform化 
- 画像投稿機能
- リファクタリング
- いいね機能 非同期化