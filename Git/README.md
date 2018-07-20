# Git学习笔记
### git配置
        git config user.name 'username'
        
        git config user.email 'email'
### 初始化仓库
        git init
### 添加文件到暂存区
        git add filename

        可能遇到的问题:
        warning: LF will be replaced by CRLF in readme.txt.The file will have its original line endings in your working directory  
        这是因为git配置core.autocrlf = true 导致的，当autocrlf为true，git自动将添加至暂存区的文件中换行符为crlf替换为lf，checkout时再换回来，也就是说始终保证工作区的换行符为crlf，所以在window环境下可以配置该选项（linux下强烈建议配置为false）  
        CRLF：CarriageReturn LineFeed，回车 换行
### 提交到版本库
        git commit -m '提交信息'
### 查看当前版本库状态
        git status
### 查看文件改动
        git diff file
### 最近提交日志
        git log

        git log --pretty=oneline 信息一行显示
### 版本回退
        git reset --hard HEAD^ 回退到上一个版本

        git reset --hard 版本号前几位
### 查看命令历史
        git reflog （和版本有关的），一般用于回到未来的版本，却不知道版本号

        git checkout -- file 回退到最近版本或暂存区
        
        如果checkout之前有git add，则回退到add之后的状态
        如果checkout之前没有git add，回退到最近版本之后的状态
### 从暂存区撤销
        git reset HEAD file 暂存区删除所有该文件的修改，工作区保持
### 删除文件
>先在工作区删除文件

        git rm file 删除暂存区的文件
        git commit -m 'msg' 提交删除
### 远程仓库
* git和github通信需要ssh加密
* 生成秘钥
        
        ssh-keygen -t rsa -C "youremail@example.com"
* 给本地仓库关联一个远程仓库
        
        git remote add origin git@github.com:michaelliao/learngit.git
* 将master推动到远程仓库
        
        git push -u origin master（加上了-u参数，Git不但会把本地的master分支内容推送的远程新的master分支，还会把本地的master分支和远程的master分支关联起来，在以后的推送或者拉取时就可以简化命令）
        
        注意如果创建的远程仓库不为空（比如在创建时选了readme.md等），则在本地不能直接push（本地关联的仓库不能有文件），必须先clone下来。空仓库才可以push（相当于初始化仓库）git pull origin master     
* 克隆仓库
        
        git clone git@github.com:xiaoxielun/test.git

### 分支
* 创建分支
        
        git branch dev
* 切换分支
        
        git checkout dev
* 创建并切换到分支
        
        git checkout -b dev
* 分支列表
        
        git branch