# Linux学习笔记

* [很多指令](#commands)
* [ls](#ls)
* [vi](#vi)
* [shell script](#shell-script)
* [read](#read)
* [cat](#cat)
* [head tail](#head-tail)
* [find](#find)
* [grep](#grep)
* [sort](#sort)
* [uniq](#uniq)
* [df du](#df-du)
* [wget](#wget)
* [curl](#curl)
* [jobs](#jobs)
* [fg](#fg)
* [tput](#tput)
* [time](#time)
* [tar](#tar)
* [gzip](#gzip)
* [bzip2](#bzip2)
* [lzma](#lzma)
* [zip](#zip)
* [ps](#ps)
* [which](#which)
* [whereis](#whereis)
* [file](#file)
* [kill](#kill)
* [uname](#uname)
* [mktemp](#mktemp)
* [split](#split)
* [xargs](#xargs)
* [comm](#comm)
* [sed](#sed)
* [awk](#awk)
* [tr](#tr)
* [touch](#touch)
* [用户管理](#user-manage)
* [日志文件](#log)
* [diff](#diff)
* [wc](#wc)
* [网络](#network)
* [ssh](#ssh)
* [ftp](#ftp)
* [convert](#convert)
* [lynx](#lynx)
* [ffmpeg](#ffmpeg)
* [paste](#paste)
* [目录权限](#directory)
* [加解密](#crypt)
* [md5](#md5)
* [tree](#tree)
* [expect](#expect)

---
### commands
* usr（Unix System Resource），即Unix系统资源的缩写
* `echo -e` 带转义字符打印
* `echo -e "\e[0;40m asdasd \e[0m"` 彩色输出
* `field=val` 设置变量
* `export field` 将变量设置为环境变量
* `netstat -tuln` 当前主机服务的项目

    ---
* `ln /文件` 创建实体链接
* `ln -s /文件` 创建软链接（符号链接）
* `lsblk` 列出系统上的所有磁盘列表

    ---
* `set` 本地变量
* `env` 环境变量
* `uptime` 系统运行时间

    ---
* `who` 获取当前登录用户的相关信息
* `w` 获取登录用户的详细信息
* `users` 当前登录用户
* `last` 上一次用户登录会话信息
* `last -f file` 保存到文件
* `last reboot` 重启列表
* `lastb`

    ---
* `watch command` 检视命令输出，每隔2秒执行一次命令
* `watch -n num command`
* `watch -d commnad`

    ---
* `date +%s` 打印时间戳
* `date --date "标准格式日期" +%s +%a +%A` 按格式打印时间

    ---
* `pushd` 将指定目录压入栈中
* `dirs` 列出当前栈中的所有目录
* `pushd +n` 切换到栈中目录
* `popd` 弹出当前目录，切换到下一个目录
* `popd +n` 弹出指定偏移目录，切换到下一个目录
* `cd -` 切换到上一个目录
* `cd ~` 切换到用户目录

---
### ls
* `ls > file` 或者 `ls 1> file` 将标准输出重定向到文件
* `ls 2> file` 将stderr重定向到文件
* `ls 2>&1 file` 或者 `ls &> file` 将stdout、stderr重定向到一个文件
* `ls | tee file` 数据重定向到文件、但不会影响stdout
* `ls -F` 在输出项都添加一个代表文件类型的字符。@、*、|、/等。/表示目录

---
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
    
---
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

---
### read
* `read -n 5 var` 读取n个字符自动结束并存入变量
* `read -s var` 无回显方式读取输入
* `read -p ‘提示信息’ var` 显示提示信息
* `read -t 10 var` 在特定时间内读取输入
* `read -d : var` 使用特殊定界符作为输入的结束
* `getline` 从标准输入获取一行

---
### cat
* `echo "hello" | cat - file` 将stdin和文件数据结合
* `cat -s file` 省略多余空行
* `cat -T file` 将制表符换为^|显示
* `cat -n file` 每行显示行号
* `cat -b file` 除空行外显示行号
* `tac file1` 从后往前逐行打印文本

---
### head tail
* `head file` 打印前10行
* `head -n 4 file` 打印前几行
* `head -n -10 file` 打印除最后几行之外的所有行
    
    ---
* `tail file` 打印最后10行
* `tail -n 10 file` 打印最后几行
* `tail -n +m` 打印出前m-1行之外的所有行

---
### find
* `find dir` 列出目录及子目录下所有文件和目录
* `find dir -name "*.php"` 列出目录下文件名包含.php的文件名
* `find dir ! -name "*.php"` 列出匹配以外的文件和目录名
* `find dir -type f` 根据文件类型搜索
* `find dir -maxdepth 3` 指定搜索文件的深度
* `find dir -atime/-amin -7` 搜索在指定时间访问或修改的文件名，-小于+大于
* `find dir -size` 文件单元大小 搜索满足指定大小的文件
* `find dir -name "" -delete` 删除匹配的文件
* `find -perm 777` 根据文件所有权进行匹配
* `find dir -user username` 特定用户的文件
* `find dir -name "" -exec cat {} \;` 找到的文件执行命令
* `find dir \( -name ".git" -prune \) -o \( -type f -print \)` 排除部分目录

---
### grep
* `grep "匹配模式" file_1 file_2 file_3`
* `grep -v "匹配模式" file` 输出除匹配行之外的所有行
* `grep -E "正则表达式" file` 使用正则表达式匹配
* `grep -c "匹配模式" file` 统计匹配的行数
* `grep -n "匹配模式" file` 同时输出行数和匹配行
* `grep -o "匹配模式" file` 只显示匹配的字符
* `grep -b -o "匹配模式" file` 打印匹配字符的偏移
* `grep -l "匹配模式" file` 打印匹配的文件名
* `grep "匹配模式" 目录 -r -n` 对目录递归搜索
* `grep -i "匹配模式"` 忽略大小写
* `grep -e "匹配模式" -e "匹配模式" file` 多个匹配模式
* `grep -f file1 file2` 指定文件中的所有行作为匹配模式
* `grep -r "匹配模式" --include *.php` 递归匹配时指定文件名
* `grep -r "匹配模式" --exclude *.php` 递归匹配时排除文件名
* `grep -q "匹配模式"` 不输出任何信息
* `grep "匹配模式" -A n` 打印匹配之后的n行（包括匹配行）
* `grep "匹配模式" -B n` 打印匹配之前的n行（包括匹配行）
* `grep "匹配模式" -C n` 打印匹配之前和之后的n行（包括匹配行）

---
### sort
* `sort file1 file2 ...` 将文件内容排序
* `sort -n file` 按数字大小排序
* `sort -r file` 逆序排序
* `sort -M file` 按月份排序
* `sort -m file_sorted1 file_sorted2` 合并已排序文件
* `sort -k 1 file` 指定按哪列排序
* `sort -k 1,3` 指定按哪几个字符排序
* `sort -k 2,2` 指定按前几个字符排序

---
### uniq
* `uniq file` 只显示一行
* `uniq -u file` 不显示连续出现的同行
* `uniq -c file` 统计各行出现次数
* `uniq -d file` 找出连续出现的行

---
### df du
* `df` 列出文件系统的整体使用量
* `du filename` 找出某个文件占用磁盘空间(disk usage)
* `du *`
* `du -a dir` 递归查找文件大小
* `du -h file` 以kb、mb为单位显示占用量
* `du -c file` 最后加一行总计
* `du -s file` 显示用量统计
* `du -b file` 单位字节
* `du -k file` 单位kb
* `du -m file` 单位mb
* `du -B block_size file` 指定块大小，以块为单位显示
* `du --exclude "*.jpg" dir` 统计时排除匹配的文件
* `du --exclude-from file dir` 排除的文件从一个文件中读取
* `du --max-depth num dir` 指定递归最大深度

---
### wget
* `wget url1 url2`
* `wget -t n url` 如果失败，最多重试n次
* `wget -t 0 url` 不停尝试获取
* `wget --limit-rate 20k url`	限制下载带宽
* `wget --quota或-Q 100m url` 限制下载量
* `wget -c url` 从之前终端继续
* `wget --mirror --convert-link url` 获取网站所有页面
* `wget -r -N -l -k DEPTH url`
* `wget --user username --password pass url`	访问需要验证的网站
* `wget url --post-data="key1=val1&key2=val2"` 发送post请求

---
### curl
* `curl url` 下载文件输出到终端
* `curl url --silent` 不显示下载进度信息
* `curl url -O` 下载结果至文件,文件从url中获取，没有会报错
* `curl url -o file` 下载结果至文件
* `curl url --progress` 下载过程只显示进度条

    ---
* `curl url -C offset` 从偏移处开始下载
* `curl -C - url` 继续下载

    ---
* `curl --referer referer_url target_url` 指定参照页字符串
* `curl url --cookie "key1=val1;key2=val2"` 指定cookie
* `curl url --user-agent "Mozilla/5.0"` 指定用户代理
* `curl url -H "Host:www.xxx.org"` 指定其他头部信息
* `curl url --limit-rate 20k` 限定可用带宽
* `curl URL --max-filesize bytes` 指定下载最大文件大小
* `curl -u user:pass url` http验证
* `curl -I 或 --head url` 只打印响应头部信息
* `curl url -d "key1=val1&key2=val2"` 发送post请求

---
### jobs
>观察目前后台工作状态

* `jobs -l` 除了列出job number与指令串之外，同时列出PID的号码
* `jogs -r` 仅列出正在后台run的工作
* `jobs -s` 仅列出正在后台中暂停（stop）的工作

---
### fg
>fg（foreground）将后台工作拿到前台，其中‘-’表示倒数第二个放到后台的工作，‘+’表示最后一个放到后台的工作

* `fg 1`
* `fg %1`
* `fg -`
* `fg +` 等同于fg

---
### tput
>获取终端信息

* `tput cols` 终端列数
* `tput lines` 终端行数
* `tput longname` 终端名
* `tput cup 10 10` 将光标移至坐标处
* `tput sc` 存储光标的位置
* `tput rc` 恢复光标位置
* `tput setb 0-7` 设置终端背景颜色
* `tput setf 0-7` 设置终端字体颜色
* `tput bold` 设置字体为粗体
* `tput smul` 下划线开始
* `tput ed` 删除光标到行尾所有内容
* `tput rmul` 下划线结束
* `stty -echo` 禁止将输出发送至终端，用于输入密码
* `stty echo` 取消禁止输出

---
### time
>命令的时间输出到标准错误，可以使用 2> 重定向到文件

* `time command` 命令执行时间
* `/usr/bin/time -o output.text command` 输出保存到文件中
* `/usr/bin/time -ao output.txt command` 输出追加到文件中
* `/usr/bin/time -f "%e%U%s" command` 格式化输出

---
### tar
* `tar -cf output.tar file1 file2 file3 ...` 对文件进行归档
* `tar -tf tarfile` 列出归档文件所包含的文件，f必须在最后面
* `tar -tvf tarfile` 列出归档文件列表，同时输出更多文件细节
>-c（创建文件） -f（指定文件名）-v（“冗长模式”verbose，显示更多信息）

* `tar -rf tarfile newfile` 向一个已经存在的归档文件添加文件

* `tar -xf tarfile` 从归档文件提取文件或文件夹（x:exact提取）
* `tar -xf tarfile -C path` 提取文件时指定保存路径
* `tar -xf tarfile file1 file2` 提取指定文件

* `tar -Af tar1 tar2` 合并两个归档文件，合并到第一个归档文件
* `tar -uf tarfile file` 检查file时间戳来更新归档文件中的内容，追加文件
>从归档文件提取文件或文件夹时，会提取最新的文件

* `tar -df tarfile file` 比较归档文件和文件系统中文件的差异
* `tar -f tarfile --delete file` 删除归档文件中的文件
* `tar --delete -f tarfile file1 file2` 同上

* `tar acvf tarfile.gz file1 file2 file3` 根据指定扩展名自动压缩
* `tar -xjvf  tarfile.bz2` 解压缩bzip2格式文件，并从归档中取出文件
* `tar -cvvf --lzma tarfile.lzma files` 使用lzma压缩归档文件
>-z表示使用gzip -j表示使用bzip2

* `tar xavf tarfile -C path` 根据文件后缀自动判断使用哪种解压缩
* `tar cf tarfile * --exclude "*.txt”"`	归档时排除部分文件或文件夹
* `tar cf tarfile * -X file` 归档时排除file中指定的文件
* `tar --exclude-vcs -cvf tarfile path` 归档时排除.git、.svn等版本控制特殊目录
* `tar -cvf tarfile file --totals` 归档后打印字节数

---
### gzip
* `gzip filename` 使用gzip压缩文件
* `gunzip filename`	解压文件
* `gzip -l gzipfile` 列出压缩文件属性信息
* `cat file | gzip -c > file.gz` 从stdin读入并压缩，保存至指定文件
* `zcat file` 不需要解压，直接读取gzip格式文件
* `gzip -5 file` 指定压缩率，压缩等级1-9

---
### bzip2
* `bzip file` 使用bzip2进行压缩
* `bunzip file`	解压缩bzip2格式文件

---
### lzma
* `lzma file` 使用lzma压缩文件
* `unlzma file.lzma` 解压缩lzma格式文件

---
### zip
* `zip file.zip file1 file2` zip格式压缩
* `zip -r file.zip dir` 递归压缩目录
* `unzip file.zip` 解压缩zip格式文件
* `zip file.zip -u newfile` 向zip文件中添加新内容
* `zip -d file.zip file` 从zip文件中删除文件
* `unzip -l file.zip` 列出压缩文件列表

---
### ps
* `ps` 不带参数，只显示运行在当前终端的进程
* `ps -f` 显示更多信息（full）
* `ps -e` 显示运行在系统上的每一个进程（every）-ax（all）有同样的功能
* `ps -eo pcpu,comm,uid...`	指定显示的信息
* `ps -eo pcpu,comm... --sort +pcpu` 指定列进行排序,+升序,-降序
* `ps -C comm` 根据进行命令名查找进程信息
* `ps -o comm=` =移除列名称，只有一列的情况
* `ps -t tty` 使用tty过滤输出
* `ps -eLf` 显示与进程相关线程信息
* `ps -eo cmd e` 显示进程的环境变量

* `pgrep comm（可以是命令的一部分）` 显示指定进程名称的所有进程id
* `pgrep -u user` 显示某用户的进程id
* `pgrep -c comm` 显示匹配进程名称的进程数

---
### which 
>找出某个命令的位置

---
### whereis
>命令位置，命令手册位置，源码位置

---
### file
* `file filename` 文件类型信息
* `file -b filename` 打印不包括文件名的文件类型信息

---
### kill
* `kill -l` 列出所有可用信号
* `kill pid1 pid2` 终止进程，进程id之间用空格隔开
* `kill -s signal pid` 杀死进程
* `kill -s SIGKILL pid` 或者 kill -9 pid强行杀死进程
* `killall process_name` 通过进程名称终止进程
* `killall -s SIGNAL process_name` 通过进程名称向进程发送信号
* `killall -9 process_name` 通过进程名称强行杀死进程
* `killall -u username process_name` 通过进程名称和所属用户终止进程
* `pkill process_name` 通过进程名称终止进程

---
### uname
* `hostname` 当前系统主机名
* `uname -n` 
* `uname -a` linux内核版本、硬件架构等
* `uname -r` linux内核发行版本
* `uname -m` 主机类型

---
### mktemp
>临时文件、目录

* `mktemp`创建临时文件
* `mktemp -d` 创建临时目录
* `mktemp -u` 创建临时文件名
* `mktemp test.XXX` 根据模板创建临时文件(X会被随机替换，保证最少出现3个X)

---
### split
* `split -b 10k` 文件分隔
* `split -d` 新文件后缀用数字
* `split -a 后缀长度` 最后可以添加一个文件名前缀参数
* `split -l 10` 按行数分割文件
* `csplit filename /分隔字符/ -n 2(文件名后缀数字个数) {*}(分隔几次) -s(不打印任何信息) -f 文件名前缀 -b 文件名后缀` 根据文件内容分割文件

---
### xargs
* `cat file | xargs` 将多行输入转换为单行输出
* `cat file | xargs -n num` 将单行输入转换为多行输出
* `echo "1,2,3,4,5" | xargs -d ,` 指定定界符分隔输入
* `cat file | xargs -n 1 ./shell.sh` 将输出作为命令参数	
* `cat file | xargs -I {} ./shell.sh -p {} -l` 指定参数位置

---
### comm
>comm命令需要文件都已排序

* `comm file1 file2` 结果中第一列显示只出现在file1中的行、第二列显示只出现在file2中的行、第三列显示都出现的行
* `comm file1 file2 -1 -2` （不显示第一列、不显示第二列）两文件交集

---
### sed
* `sed "s/匹配模式/替换字符/"` 替换匹配的字符
* `sed -i "s/匹配模式/替换字符/" file` 将结果保存到指定文件中，且指定文件必须已经存在
>sed替换时只替换每行第一个匹配的字符

* `sed "s/匹配字符/替换字符/g" file` 替换每行所有匹配的字符
* `sed "s/匹配字符/替换字符/N" file` 替换第N处匹配的字符
* `sed "s/匹配字符/替换字符/Ng" file` 从第N处开始替换
>匹配字符中的|，需要用\转义才能表达"或"的语法

* `sed "s/^\t//"` 删除输出中的空白字符
* `sed “/^$/d” file` 使用sed移除文本中的空行 
* `sed -i.bak "s/匹配字符/替换字符/g" file` 在替换源文件的同时，生成指定后缀的源文件副本
* `sed "s/匹配字符/&/g" file` 其中&表示之前匹配到的字符， \1是第一个字串 \2是第二个字串
* `sed "expression" | sed "expression"	sed "expression; expression"`
* `sed -e "expression" -e "expression"` 表达式可以使用变量

---
### awk
* 基础用法：`awk 'BEGIN{} pattern{} END{}'` 
* 特殊变量：NR行号，NF当前行字段数，$0当前行全部内容，$1当前行第一个字段，$2....
* 外部变量：
        `awk -v VARNAME=$var 'BEGIN{} {} END{}'`
        `awk '{} {} {}' val1=$val1 val2=$val2`
* `getline var` 读取一行，至变量var
* `getline` 读取一行，使用$0、$1、$2访问
* 过滤模式:
        `awk "NR <5"` 行号小于5的行
        `awk "NR==1, NR==4"` 行号在1到5之间的行
        `awk "/linux/"` 包含样式linux的
        `awk "!/linux/"` 不包含包含模式为linux的行
        `awk -F` 指定字段定界符，默认是空格，或者在BEGIN中设置FS="",输出定界符用OFS=""来设置
* 读取命令输出
        `"command" | getline output`
        
---
### tr
* `echo 'hello' | tr 'a-z' 'A-Z'` 替换标准输入的字符串中的字符 
* `cat file | tr - d 'acas'` 删除字符					
* `tr -c 'ad'` 指定字符集的补集，即除ad之外的字符
* `tr -s ' '` 压缩字符					

---
### touch
>创建空白文件

* `touch file` 生成一个空白文件，如果文件已经存在，会将文件的所有时间变为当前时间
* `touch -a` 只修改文件访问时间
* `touch -m` 只修改文件最后修改时间
* `touch -d` 指定时间

---
### user manage
* `useradd username -m` 新加用户，并创建工作目录
* `deluser username --remove-all-files`	删除用户，并删除工作目录左右文件
* `finger username` 用户信息
* `chage -l username` 用户密码操作信息
* `passwd username` 修改用户密码
* `usermod -L username`	锁定用户密码，使密码验证无效
* `usermod -U username` 解锁用户密码，恢复使用
* `chsh	username -s shell` 修改用户shell
* `chage -E date` 用户将在date过期，无法使用
* `addgroup	name` 添加用户组
* `delgroup name` 删除组
* `addgroup username groupname`	将用户username添加到groupname组中

---
### logrotate
>日志轮换（轮转）工具

* 默认配置文件 `/etc/logrotate.conf`
* 自定义配置目录 `/etc/logrotate.d`，该目录下的所有文件会被当做配置文件使用，所以如果有新的服务日志需要处理，就可以单独配置轮换规则。
* 命令格式
        logrotate [option] <configfile>
        -d,--debug:debug模式,测试配置文件是否有错误
        -f,--force:强制转储文件
        -m,--mail=command:压缩日之后,发送日志到指定邮箱
        -s,--state=statefile:使用指定的状态文件
        -v,--verbose:显示转储过程	

---
### cut
>将文本按列切分

* `cut -fn filename` 显示第n列，'\t'为默认定界符
* `cut -f n1,n2 filename` 显示第n1、n2列
* `cut -fn --complement file` 显示除第n列之外的所有列
* `cut -fn -d file` 指定定界符
* `cut -c1-5 file` 	切出每行1-5的字符
* `cut --output-delimiter=" "` 指定输出定界符

---
### log
* `/var/log/boot.log` 本次开机启动信息
* `/var/log/cron`
* `/var/log/dmesg` 记录系统在开机的时候核心侦测过程所产生的各项信息
* `/var/log/lastlog` 可以记录系统上面所有的帐号最近一次登陆系统时的相关信息
* `/var/log/messages` 这个文件相当的重要，几乎系统发生的错误讯息 （或者是重要的信息）都会记录在这个文件中
* `/var/log/secure` 基本上，只要牵涉到“需要输入帐号密码”的软件，那么当登陆时（不管登陆正确或错误）都会被记录在此文件中
* `/var/log/wtmp, /var/log/faillog` 这两个文件可以记录正确登陆系统者的帐号信息（wtmp） 与错误登陆时所使用的帐号信息（faillog）

---
### diff
* `diff file1 file2` 生成差异文件
* `diff -u file1 file2 > new_file`
* `patch -p1 file1 < new_file` 对文件进行修补
* `patch -p1 file1 < new_file` 再次执行撤销修改

---
### wc
* `wc -l file` 统计文件行数
* `wc -w file` 统计文件单词数
* `wc -c file` 统计文件字符数
* `wc file -L` 打印文件中最长的一行的长度

---
### network
* `ifconfig` 列出当前网络接口配置
* `ifconfig wlan0 192.168.0.80`	手动设置网络接口ip地址
* `ifconfig wlan0 192.168.0.80 netmask 255.255.254.0` 子网掩码
* `dhclient eth0` 自动配置网络接口
* `ifconfig eth0 hw ether 00:1C:bf:87:25:d5` 硬件地址欺骗
* `host 域名` 列出域名的所有ip地址
* `nslookup域名`	 查询dns相关细节信息

    ---
* `route` 显示路由表
* `route -n` 以数字形式显示路由地址
* `route add default gw 192.168.1.0 wlan0` 添加默认网关

    ---
* `ping address` 检查是否可以到达
* `ping address -c count` 指定次数

---
### ssh
    ssh name@host_ip command
    
---
### ftp
    lftp username@host
    
---
### convert
* `convert file -resize "100x" newfilename` 生成缩略图
* `convert file -resize "50%" newfile` 按比例缩小、放大图片

---
### lynx
* `lynx -dump url` 打印url，html解析后的纯文本

---
### ffmpeg 
        // 截取视频文件某一帧
        ffmpeg  -i  filename(视频文件) -y -f image2 -ss 10(那一秒的画面) -t 0.001 -s 200x100(图片大小) filename(保存的图片名)

>常见用法:https://www.cnblogs.com/wainiwann/p/4128154.html

---
### paste
* `paste file1 file2` 将两个文件按列拼接
* `paste file1 file2 -d ","` 指定定界符

---
### directory
>目录的读权限（r）允许读取目录中文件和子目录的列表

>目录的写权限（w）允许在目录中创建或删除文件或目录

>目录的执行权限（x）指明是否可以访问目录中的文件和子目录

>目录有一个特殊的权限，叫做粘滞位（sticky bit）。如果目录设置了粘滞位，只有创建该目录的用户才能删除目录中的文件，即使用户组和其他用户也有写权限，也无能无力。粘滞位出现在其他用户权限中的执行权限（x）位置。它使用t或T来表示。如果没有设置执行权限，但设置了粘滞位，就使用t；如果同时设置了执行权限和粘滞位，就使用T

---
### crypt
* crypt 
    >加密`crypt < filename > output`
    
    >解密`crypt password -d < filename`
* gpg
    >加密`gpg -c fiename`
    >解密`gpg filename`
* base64(编码)
    >编码`base64 filename`
    >解码`base64 -d filename`
* shadow-like(散列)
    >`openssl passwd -1 -salt '' 'password'`

---
### md5
>校验与核实

>`md5sum filename > file.md5`

>`md5sum -c file.md5`

---
### tree
* `tree dir` 以树状形式打印目录结构
* `tree dir -P "*.php"` 重点打印出符合匹配的文件
>同时打印出文件或目录大小

---
### expect
>自动化脚本输入

    1.sh
    #!/bin/bash
    read -p “input name:” name
    read -p “input age:” age
    echo $name,$age

    2.sh
    #!/usr/bin/expect
    spawn ./1.sh
    expect “input name:”
    send “yc\n”
    expect “input age:”
    send “23\n”
    expect eof
    
    ./2.sh

---
### 修改文件为不可修改状态
* `chattr +i file` 将文件设置为不可修改
* `chattr -i file` 文件恢复可写状态

---
### 使用环回文件
* `mkfs.ext4 filename` 将文件格式化成ext4文件系统
* `mount -o loop filename path` 挂载环回文件系统
* `umount path` 卸载挂载
