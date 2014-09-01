class UsersController < ApplicationController
  before_action :set_user, only: [:show, :edit, :update, :destroy]

  # GET /users
  # GET /users.json
  def index
    @message = params[:q]
    @oder_by = params[:order_by]
    @order = params[:order]

    @url = '?q=' + @message.to_s + '&order_by' + @oder_by.to_s + '&order' + @order.to_s

    if @order_by == nil
      @order_by = 'id'
    end

    if @order != 'ASC'
      @order = 'ASC'
    else
      @order = 'DESC'
    end

    if @message
      @users = User.where("name LIKE '%#{@message}%'").order(@oder_by.to_s + ' ' + params[:order].to_s).all
    else
      @users = User.order(@oder_by.to_s + ' ' + params[:order].to_s).all
    end
  end

  # GET /users/1
  # GET /users/1.json
  def show
  end

  # GET /users/new
  def new
    @user = User.new
  end

  # GET /users/1/edit
  def edit
  end


  require 'timeout'
  # POST /users
  # POST /users.json
  def create
    @user = User.new(user_params)

    respond_to do |format|
      if @user.url =~ URI::regexp
        begin
          status = Timeout::timeout(5) {

            uri = URI.parse(@user.url)
            http = Net::HTTP.new(uri.host, uri.port)  
            code = http.head(uri.request_uri).code

            if code != '200' 
              format.html { render :new, :locals => {:notice => "Error: Bad code from server "}}
            else
              if @user.save
                format.html { redirect_to @user, notice: 'User was successfully created.' }
              else
                format.html { render :new }
              end
            end
        
          }
        rescue Timeout::Error
          http.finish
          format.html { render :new, :locals => {:notice => 'That took too long, exiting...' }} 
        end

      else
        format.html { render :new, :locals => {:notice => "Error: Wrong URL"}}
      end
    end
  end

  # PATCH/PUT /users/1
  # PATCH/PUT /users/1.json
  def update

    respond_to do |format|
      if params[:user][:url] =~ URI::regexp
        begin
          status = Timeout::timeout(5) {

            uri = URI.parse(params[:user][:url])
            http = Net::HTTP.new(uri.host, uri.port)  
            code = http.head(uri.request_uri).code

            if code != '200' 
              format.html { render :new, :locals => {:notice => "Error: Bad code from server "}}
            else
              if @user.save
                format.html { redirect_to @user, notice: 'User was successfully created.' }
              else
                format.html { render :new }
              end
            end
          }
        rescue Timeout::Error
          http.finish
          format.html { render :new, :locals => {:notice => 'That took too long, exiting...' }} 
        end
      else
        format.html { render :new, :locals => {:notice => "Error: Wrong URL"}}
      end
    end
  end

  # DELETE /users/1
  # DELETE /users/1.json
  def destroy
    @user.destroy
    respond_to do |format|
      format.html { redirect_to :back, notice: 'User was successfully deleted.' }
    end
  end

  private
    # Use callbacks to share common setup or constraints between actions.
    def set_user
      @user = User.find(params[:id])
    end

    # Never trust parameters from the scary internet, only allow the white list through.
    def user_params
      params.require(:user).permit(:name, :url)
    end
end
