function strToMatriz(strArray,separate1,separate2){
    var arrayRow=strArray.split(separate2);
    var matriz=new Array();
    for (a=0; a < arrayRow.length; a++){
        var arrayCol=arrayRow[a].split(separate1);
        matriz[a]=arrayCol;       
    }
    return matriz;
}

function bubbleMatrix(matrix,sortNumCol,ofWhatToWhat){
    var arrayAux=new Array();
    var array1=new Array();
    var array2=new Array();
    for(i=0;i<matrix.length;i++){                  
        for(j=i+1;j<matrix.length;j++){            
             if (ofWhatToWhat=='>'){
                 array1=matrix[i][sortNumCol];
                 array2=matrix[j][sortNumCol];
             }
             else if (ofWhatToWhat=='<'){
                 array1=matrix[j][sortNumCol];
                 array2=matrix[i][sortNumCol];
             }           
            if (array1<array2){
                arrayAux=matrix[i];
                matrix[i]=matrix[j];
                matrix[j]=arrayAux;
            }
       }
    } 
    return matrix;
}

function selectMatrixColumns(oldMatrix,fromCol,toCol){
var newMatrix=new Array();  
var newRow=0;
var newCol=0;
for(var oldRow in oldMatrix) {  
    newMatrix[newRow]=new Array();         
    for(var oldCol in oldMatrix[oldRow]){
        if (oldCol>=fromCol && oldCol<=toCol) {
            newMatrix[newRow][newCol]=oldMatrix[oldRow][oldCol];
            newCol++;
        }        
    }
    newCol=0;
    newRow++;    
    }
    return newMatrix;
}

function removeMatrixColumns(oldMatrix,fromCol,toCol){
var newMatrix=new Array();  
var newRow=0;
var newCol=0;
for(var oldRow in oldMatrix) {  
    newMatrix[newRow]=new Array();         
    for(var oldCol in oldMatrix[oldRow]){
        if (!(oldCol>=fromCol && oldCol<=toCol)) {
            newMatrix[newRow][newCol]=oldMatrix[oldRow][oldCol];
            newCol++;
        }        
    }
    newCol=0;
    newRow++;    
    }
    return newMatrix;
}

function pivotMatrix(oldMatrix){
    var newMatrix = new Array();
    var l=0;
    for (var x=0;x<(oldMatrix[0].length); x++){
        newMatrix[x] = new Array();
        for(var i in oldMatrix){
            newMatrix[x][l]=oldMatrix[i][x];  
            l++;
        }
        l=0;   
    }    
    return newMatrix;
}  