# Linux学习笔记

## 目录
* [vi](#vi)
* [shell script](#shell-script)
* [read](#read)

### vi
有三种模式：一般指令模式、编辑模式、命令行命令模式。

* 一般指令模式

    * H将光标移动到当前屏幕的顶部
    * M将光标移动到当前屏幕的中部
    * L将光标移动到当前屏幕的底部
    ---
    * gg将光标移动到第一列
    * nG将光标移动到第n列
    * G将光标移动到最后一列
    * n[space]将光标向后移动n个字符
    * n[enter]将光标向下移动n列（n↓）
    ---
    * dd删除光标一行
    * ndd删除从光标开始的n行
    * dG删除光标到最后一行
    * d$删除光标到最后的字符
    * d0删除第一个字符到光标的字符
    ---
    * v,V,ctrl+v区块选择
    * yy复制一整行
    * p,P粘贴
    ---
    * . 重复前一个动作
    * ctrl+x、ctrl+o针对文件扩展名的补全功能
* 编辑模式
    >通过键入a、i 进入编辑模式
* 命令行命令模式
    * :n1,n2s/word1/word2/gc查找并替换
    * :n :N :files多文件编辑
    * :sp多窗口功能
    * :set nu显示行号
    * :set nonu不显示行号
    * `/匹配字符`查找字符，n下一个，N上一个
    
### shell script
>大多数脚本第一行如下：`#!/bin/bash`，这被称为"shebang"，指明用哪个shell运行脚本

* 变量
    * `${field}`，变量值
    * `${varname:'10'}`，变量不存在时给一个默认值
    * `${var/匹配模式/替换字符}`，将变量$var中匹配的字符替换
    * `${var:start_index:length}`，截取字符串
    ---
    * `${filename%.*}`，匹配文件名，%的含义是删除filename中匹配.*的字符，从右往左匹配
    * `${filename%%.*}`，%%是贪婪模式的匹配
    * `${filename#*.}`，匹配扩展名，#的含义是删除*.匹配的内容，从左往右匹配
    ---
    * `$(#field)`，变量field的长度
    * `$0`或者`$SHELL`，当前使用哪个shell
    * `$UID`，执行当前脚本用户uid，0为root用户
    * `$PS1`，提示字符串格式，可以通过export临时修改提示字符格式
    ---
    * `$#`，参数个数
    * `$@`，"$1""$2""$3""$4"...
    * `$*`，"$1 $2 $3 $4"
* 数组
    * `arr=(1 2 3 4 5 6)`，定义数组
    * `${arr[0]}`，数组某个元素 	
    * `${arr[*]}` 或者 `${arr[@]}`，以清单形式列出数组
    * `${#arr[*]}`，数组长度 		
    * `$(!arr[*])`，列出数组所有索引
    * `declare -A arr`  
      `arr=([index1]=val1 [index2]=val2)`，定义关联数组
* 函数
        // 定义函数  
        function fname()  
        {
    
        }
* 分支
        case "" in
        
            "")  
                some expression ;;  
            "")  
                some expression ;;   
        esac
* 循环
    * while
            while []
            do
                some expression
            done

    * until
            until []
            do
                some expression
            done
        
    * for
            for var in arr
            do
                some expression
            done
            
            for((i=1;条件;步进)) // 括号里可以有空格
            do
                some expression
            done
* 条件
    >条件写在中括号中，中括号中前后要留空格  
    >条件逻辑运算:逻辑与 `-a` 逻辑或 `-o`
    
        if [ 条件 ] ;then
            some expression
        elif [ 条件 ] ;then
            some expression
        else
            some expression
        fi
    
        // 字符串比较
        if [[ str1 = str2 ]] ;then
            some expression
        fi
        if [[ str1 == str2 ]] ;then
            some expression
        fi
        // 常用比较
        if [ ! -e "file_path" ] ;then 
            文件不存在
        fi
        if [[ -n "$var" ]] ;then
            变量不为空
        fi
* 利用子shell读取命令输出
        output=$(ls | cat -n)
        output=`ls | cat -n`
* 算数运算
    * $((算术表达式))
    * 使用let、(())、[]执行算术运算
* `bash -x file.sh` 开启调试
* 命令起别名（退出shell后无效）
    * alias newname="命令"
    * `unalias newname` 或者 `alias newname=`，删除命令别名
    * 通过在命令前加\,来执行原始命令
* 其它用法技巧
    * 将指令放在子shell中进行，父shell `wait` 等待执行完成
    
            for i in {0..100}
            do
            (
                sleep 0.1;
                echo $i;
            )&
            done
            wait;
    * 从子shell中读取 
    > `< <` 中间有空格
    
            while read t
            do
            done < <(echo $t)
            
### read
* `read -n 5 var` 读取n个字符自动结束并存入变量
* `read -s var` 无回显方式读取输入
* `read -p ‘提示信息’ var` 显示提示信息
* `read -t 10 var` 在特定时间内读取输入
* `read -d : var` 使用特殊定界符作为输入的结束
    