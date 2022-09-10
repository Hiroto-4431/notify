<p>=========================================================</p>

<p>予定を登録</p>
<form action="{{ route('register') }}" method="POST">
	@csrf
	<p>開始日時</p>
	<input type="text" name="start_time" required>
	<br>
	<p>終了日時</p>
	<input type="text" name="end_time" required>
	<br>
	<p>名前</p>
	<input type="text" name="name" required>
	<br>
	<p>詳細</p>
	<textarea name="description" cols="30" rows="10" required></textarea>
	<button type="submit">登録</button>
</form>

<p>=========================================================</p>

<form action="{{ route('today') }}" method="GET">
	<p>本日の予定を表示</p>
	<button type="submit">表示</button>
</form>

<p>=========================================================</p>

<form action="{{ route('tomorrow') }}" method="GET">
	<p>明日の予定を表示</p>
	<button type="submit">表示</button>
</form>

<p>=========================================================</p>

<form action="{{ route('specific') }}" method="GET">
	<p>特定の日の予定を表示</p>
	<input type="text" name="day">
	<button type="submit">表示</button>
</form>
