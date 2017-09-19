<div class="center">
    <a href="/group/create">CREATE GROUP</a>
</div>
<?var_dump($param[0]);?>
<div class="all_groups">
    <?for($i = 0; $i < count($param); $i++):?>
        <div style="width: 100%; height: 200px;">
            <a href="/group/show/<?=$param[$i]->getId();?>"><?echo $param[$i]->getName()."(".$param[$i]->getDateStart().")";?></a>
        </div>
    <?endfor;?>
</div>