<%OPTION EXPLICIT%>
<%Server.ScriptTimeOut=5000%>
<!--#include FILE="upload_5xsoft.inc"-->
<!--#include file="ASPJson.class.asp"-->
<%
response.charset="utf-8"
session.codePage = 65001
dim upload,file,formName,iCount,json,newFileName,fileExit,random
set upload=new upload_5xsoft ''建立上传对象
for each formName in upload.objFile ''列出所有上传了的文件
	set file=upload.file(formName)  ''生成一个文件对象
	if file.FileSize>0 then         ''如果 FileSize > 0 说明有文件数据
		randomize
		random = Mid(rnd, 3)
		newFileName = year(date)&month(date)&day(date)&hour(time)&minute(time)&second(time)&"-"&random
		fileExit = Mid(file.FileName,inStr(file.FileName,"."))
		file.SaveAs Server.mappath("/upfile/"&newFileName&fileExit)   ''保存文件
		set json = new ASPJson
		with json.data
			.Add "url", "/upfile/"&newFileName&fileExit
			.Add "original", File.FileName
			.Add "state", "SUCCESS"
			.Add "title", File.FileName
		end with
		json.PrintJson()
		iCount=iCount+1
	end if
	set file=nothing
next
%>