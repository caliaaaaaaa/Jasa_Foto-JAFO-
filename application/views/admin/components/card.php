<style>
.card {
    background: white;
    border-radius: 18px;
    padding: 20px;
    width: 230px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.card-title {
    font-size: 14px;
    color: #888;
}

.card-value {
    font-size: 26px;
    font-weight: 600;
    margin-top: 5px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 15px;
    width: 200px;
    box-shadow: 0 5px 10px rgba(0,0,0,0.05);
}
</style>

<div class="card">
    <div class="card-title"><?= $title ?></div>
    <div class="card-value"><?= $value ?></div>
</div>
