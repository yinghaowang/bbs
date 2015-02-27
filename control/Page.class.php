<?php
class Page
{
    public $each_disNums;
    public $nums;
    public $current_page;
    public $sub_pages;
    public $pageNums;
    public $page_array = array();
    public $subPage_link;
    public function Page($each_disNums, $nums, $current_page, $sub_pages, $subPage_link)
    {
        $this->each_disNums = intval($each_disNums);
        $this->nums         = intval($nums);
        if (!$current_page) {
            $this->current_page = 1;
        } else {
            $this->current_page = intval($current_page);
        }
        $this->sub_pages    = intval($sub_pages);
        $this->pageNums     = ceil($nums / $each_disNums);
        $this->subPage_link = $subPage_link;
    }
    public function initArray()
    {
        for ($i = 0; $i < $this->sub_pages; $i++) {
            $this->page_array[$i] = $i;
        }
        return $this->page_array;
    }
    public function construct_num_Page()
    {
        if ($this->pageNums < $this->sub_pages) {
            $current_array = array();
            for ($i = 0; $i < $this->pageNums; $i++) {
                $current_array[$i] = $i + 1;
            }
        } else {
            $current_array = $this->initArray();
            if ($this->current_page <= 3) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $i + 1;
                }
            } elseif ($this->current_page <= $this->pageNums && $this->current_page > $this->pageNums - $this->sub_pages + 1) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = ($this->pageNums) - ($this->sub_pages) + 1 + $i;
                }
            } else {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $this->current_page - 2 + $i;
                }
            }
        }
        return $current_array;
    }
    public function pageStyle()
    {
        $pageStyleStr = "";
        if ($this->current_page > 1) {
            $firstPageUrl = $this->subPage_link . "1";
            $prewPageUrl  = $this->subPage_link . ($this->current_page - 1);
            $pageStyleStr .= "<a href='$firstPageUrl'>首页</a>";
            $pageStyleStr .= "<a href='$prewPageUrl'>上一页</a>";
        } else {
            $pageStyleStr .= "<a>首页</a>";
            $pageStyleStr .= "<a>上一页</a>";
        }
        $a = $this->construct_num_Page();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->current_page) {
                $pageStyleStr .= "<a class='hover'>" . $s . "</a>";
            } else {
                $url = $this->subPage_link . $s;
                $pageStyleStr .= "<a href='$url' class='everpage'>" . $s . "</a>";
            }
        }
        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->subPage_link . $this->pageNums;
            $nextPageUrl = $this->subPage_link . ($this->current_page + 1);
            $pageStyleStr .= "<a href='$nextPageUrl'>下一页</a>";
            $pageStyleStr .= "<a href='$lastPageUrl'>尾页</a>";
        } else {
            $pageStyleStr .= "<a class='disabled'>下一页</a>";
            $pageStyleStr .= "<a class='disabled'>尾页</a>";
        }
        return $pageStyleStr;
    }
    public function __destruct()
    {
        unset($each_disNums);
        unset($nums);
        unset($current_page);
        unset($sub_pages);
        unset($pageNums);
        unset($page_array);
        unset($subPage_link);
    }
}
?>