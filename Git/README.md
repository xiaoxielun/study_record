Git学习笔记
===
目录
---
* [初始化仓库](#初始化仓库)  
* [git配置](#git配置)  
* [工作流](#工作流)
* [检查文件状态](#检查文件状态)  
* [添加文件到暂存区](#添加文件到暂存区)  
* [提交到版本库](#提交到版本库)  
* [查看文件改动](#查看文件改动)  
* [最近提交日志](#最近提交日志)  
* [版本回退](#版本回退)  
* [查看命令历史](#查看命令历史)  
* [取消文件修改](#取消文件修改)  
* [从暂存区撤销](#从暂存区撤销)  
* [删除文件](#删除文件)  
* [远程仓库](#远程仓库)  
* [分支](#分支)  
* [更新与合并](#更新与合并)  
* [标签](#标签)  

初始化仓库
---
        git init
git配置
---
        git config user.name 'username'
        
        git config user.email 'email'
工作流
---
>你的本地仓库由 git 维护的三棵“树”组成。第一个是你的 工作目录，它持有实际文件；第二个是 暂存区（Index），它像个缓存区域，临时保存你的改动；最后是 HEAD，它指向你最后一次提交的结果。

检查文件状态
---
        git status
添加文件到暂存区
---
        git add filename
>可能遇到的问题:warning: LF will be replaced by CRLF in readme.txt.The file will have its original line endings in your working directory
>
>这是因为git配置core.autocrlf = true 导致的，当autocrlf为true，git自动将添加至暂存区的文件中换行符为crlf替换为lf，checkout时再换回来，也就是说始终保证工作区的换行符为crlf，所以在window环境下可以配置该选项（linux下强烈建议配置为false）  
>CRLF：CarriageReturn LineFeed，回车 换行

提交到版本库
---
        git commit -m '提交信息'
查看文件改动
---
        git diff file
最近提交日志
---
        git log

        git log --pretty=oneline 信息一行显示
版本回退
---
        git reset --hard HEAD^ 回退到上一个版本

        git reset --hard 版本号前几位
查看命令历史
---
        git reflog （和版本有关的），一般用于回到未来的版本，却不知道版本号
取消文件修改
---
        git checkout -- file 回退到最近版本或暂存区  
>如果checkout之前有git add，则回退到add之后的状态  
>如果checkout之前没有git add，回退到最近版本之后的状态

从暂存区撤销
---
        git reset HEAD file
>暂存区删除所有该文件的修改，工作区保持修改

删除文件
---
>先在工作区删除文件

        git rm file 删除暂存区的文件
        git commit -m 'msg' 提交删除
远程仓库
---
* git和github通信需要ssh加密
* 生成秘钥
        
        ssh-keygen -t rsa -C "youremail@example.com"
* 给本地仓库关联一个远程仓库
        
        git remote add origin git@github.com:michaelliao/learngit.git
* 推送改动
    >`git push -u origin master`（加上了-u参数，Git不但会把本地的master分支内容推送的远程新的master分支，还会把本地的master分支和远程的master分支关联起来，在以后的推送或者拉取时就可以简化命令）
    
    >注意如果创建的远程仓库不为空（比如在创建时选了readme.md等），则在本地不能直接push（本地关联的仓库不能有文件），必须先clone下来。空仓库才可以push（相当于初始化仓库）`git pull origin master `    
* 克隆仓库
        
        git clone git@github.com:xiaoxielun/test.git

分支
---
>一般的，可以创建一个master分支，作为生产环境，平时不做改动，创建一个dev分支用于开发，开发和测试完成后，再将改动合并到master分支上

* 创建并切换到分支
        
        git checkout -b dev
        
    >切换分支会影响工作目录的文件内容，会切换到目标分支最后一次提交的内容

* 创建分支
        
        git branch dev
* 切换分支
        
        git checkout dev
* 分支列表
        
        git branch
* 删除分支
        
        git branch -d 分支名
    >如果分支未合并，可能不能直接删除，可以 `-D` 强制删除
        
        git branch -D 分支名
* 哪些分支已经合并到当前分支
        
        git branch --merged

* 还没有合并的分支

        git branch --no-merged
更新与合并
---
* 更新本地仓库至最新
        
        git pull
* 合并分支到当前分支
        
        git merge <branch>
        
    >可以先切换分支，然后合并  
    >如果有冲突，需要手动解决冲突，之后add commit提交新版本
        
标签
---
git tag 1.0.0 版本号

参考
---
[git - 简明指南](http://rogerdudler.github.io/git-guide/index.zh.html)
1