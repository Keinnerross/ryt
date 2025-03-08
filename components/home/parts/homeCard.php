<?php function homeCard($img, $title, $description)
{

?>
    <div class="full cursor-pointer hover:scale-[1.03] transition-all ">
        <div class="w-full h-[280px] rounded-xl overflow-hidden hover:shadow-sm">
            <img src="<?php echo $img ?>" class="w-full h-full object-cover object-top"></img>
        </div>

        <h3 class="text-2xl font-bold pt-4 pb-1"><?php echo $title ?></h3>
        <p class="text-base text-text-light"><?php echo $description ?></p>
    </div>

<?php } ?>