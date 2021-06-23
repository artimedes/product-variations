<style>
.art-preview-wrap {
	position: relative;
	border: solid 1px gray;
	padding: 10px;
}

.art-preview-work {
	position: relative;
	min-height: 150px;
}

.art-preview-work img {
	box-shadow: 1px 2px 8px -2px grey;
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	margin: auto auto 0;
}

.baklijst-blank {
	border: 4px solid #ecbc72;
    border-image-source: url(<?=$server_link?>images/lijsten/baklijst-blank.jpg);
    border-image-slice: 21 20;
    background: #dab684;
    box-shadow: inset 0px 0px 10px 0px rgba(0,0,0,.6);
    border-image-repeat: repeat;
}

.baklijst-zwart {
	border: 4px solid #ecbc72;
    border-image-source: url(<?=$server_link?>images/lijsten/baklijst-zwart.jpg);
    border-image-slice: 20 20;
    border-image-repeat: repeat;
    background: #6d7173;
    box-shadow: inset 0px 0px 10px 0px rgb(0, 0, 0);
}

.baklijst-wit {
    border: 4px solid #ddd;
    border-image-source: url(<?=$server_link?>images/lijsten/baklijst-wit.jpg);
    border-image-slice: 20 20;
    border-image-repeat: repeat;
    background: #f4f6f8;
    box-shadow: inset 0px 0px 10px 0px rgba(0,0,0,.6);
}
.bloklijst-goud {
    border: 6px solid #ecbc72;
    border-image-source: url(<?=$server_link?>images/lijsten/bloklijst-goud.jpg);
    border-image-slice: 60 60;
    border-image-repeat: repeat;
    border-radius: 0;
    box-shadow: 0 0 5px rgba(0,0,0,.5);
}
</style>