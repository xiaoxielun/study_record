Git学习笔记
===
目录
---
* [工作流](#工作流)  
* [git常用配置](#git常用配置)  
* [常用命令](#常用命令)  
* [撤销操作](#撤销操作)  
* [远程仓库](#远程仓库)  
* [分支](#分支)  
* [标签](#标签) 
* [参考](#参考)  

工作流
---
>本地仓库由 `git` 维护的三棵 " 树 " 组成。第一个是工作目录，它持有实际文件；第二个是暂存区（Index），它像个缓存区域，临时保存改动；最后是 HEAD，它指向最后一次提交的结果。

git常用配置
---
        git config user.name 'username'
        git config user.email 'email'
        git config push.default 'simple'
常用命令
---
* 初始化仓库、创建仓库

        git init
* 检查文件状态

        git status
* 添加文件到暂存区

        git add filename
    >可能遇到的问题:LF will be replaced by CRLF in readme.txt.The file will have its original line endings in your working directory
    >
    >这是因为git配置core.autocrlf = true 导致的，当autocrlf为true，git自动将添加至暂存区的文件中换行符为crlf替换为lf，checkout时再换回来，也就是说始终保证工作区的换行符为crlf，所以在window环境下可以配置该选项（linux下强烈建议配置为false）  
    >CRLF：CarriageReturn LineFeed，回车 换行

* 提交到本地版本库

        git commit -m '提交信息'
* 查看文件改动

        git diff file
* 提交日志

        git log
        git log -p -2 最近两次提交和差异
        git log --stat 每次提交的统计信息
        git log --pretty=oneline 信息一行显示
        git log --pretty=format:"%h - %an, %ar : %s"
        git log --pretty=oneline --graph
        git log --pretty="%h - %s" --author=gitster --since="2008-10-01" --before="2008-11-01" --no-merges -- t/
* 查看命令历史

        git reflog （和版本有关的），一般用于回到未来的版本，却不知道版本号

撤销操作
---
* **版本**回退

        git reset --hard HEAD^ 回退到上一个版本
        git reset --hard 版本号前几位
* 撤销**工作目录**文件修改

        git checkout -- file 回退到最近版本或暂存区  
    >如果checkout之前已经将文件修改保存到暂存区，则回退到暂存区的内容，否则回退到最新版本的内容

* 撤销**暂存区**的临时保存

        git reset HEAD file
    >暂存区删除所有**该文件**的修改，工作区不变

* 删除文件

        rm file
        git rm file 删除暂存区的文件
        git commit -m 'msg' 提交删除
        
远程仓库
---
>一般操作流程:先在github上创建一个项目，然后在本地clone项目进行开发，在提交修改前，先使用 `git pull` 将别人的改动拉下来，有冲突解决冲突，然后推送

* 克隆仓库
        
        git clone git@github.com:xiaoxielun/test.git
* 更新本地仓库至最新
        
        git pull
* git 和 github 通信需要 ssh 加密

        ssh-keygen -t rsa -C "youremail@example.com"
    >之后需要将共要添加到github的秘钥配置中

* 给本地仓库关联一个远程仓库

        git remote add origin git@github.com:michaelliao/learngit.git
* 推送改动

        git push origin master
 
分支
---
>一般的，可以创建一个master分支，作为生产环境，平时不做改动，创建一个dev分支用于开发，开发和测试完成后，再将改动合并到master分支上

* 创建分支
        
        git branch dev
* 创建并切换到分支
        
        git checkout -b dev
    >切换分支会影响工作目录的文件内容，会切换到目标分支最后一次提交的内容

* 切换分支
        
        git checkout dev
    >切换之前需要保证工作目录干净，未提交的需要提交，避免冲突
* 分支列表
        
        git branch
    >master分支与其它分支没有任何区别

* 合并分支到当前分支
        
        git merge <branch>
         
    >如果有冲突，需要手动解决冲突，之后 `add commit` 提交新版本
* 删除分支
        
        git branch -d 分支名
    >如果分支未合并，不能直接删除，可以 `-D` 强制删除
        
        git branch -D 分支名
* 哪些分支已经合并到当前分支
        
        git branch --merged
* 还没有合并的分支

        git branch --no-merged

分支-变基
---
* 概述
        
        在目标分支的基础上（共同祖先），将当前分支的改动在运行一次，git中的这种操作叫变基

        test
        rte
标签
---
    git tag 版本号 git版本号

参考
---
[git - 简明指南](http://rogerdudler.github.io/git-guide/index.zh.html)
[Git - Book](https://git-scm.com/book/zh/v2)

master